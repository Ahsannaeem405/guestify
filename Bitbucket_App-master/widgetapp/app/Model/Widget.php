<?php
class Widget extends AppModel {
    public $name = 'Widget';

    public $belongsTo = array(
        'Account',
        'Host',
        'Poll'
    );

    public $hasMany = array(
        'WidgetElement' => array(
            'conditions' => array(
                'WidgetElement.deleted' => 0
            )
        )
    );



    /**
    * iterate over all comments and calculate
    * the gsi for each guest
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $comments
    * @return mixed $comments
    */
    private function calculateGsiForComments($comments = null){
        if(!$comments){
            return false;
        }

        foreach($comments as $key => $comment){
            $rating_max     = 0;
            $rating_real    = 0;
            $count_answers  = 0;

            foreach($comment['Answer'] as $innerkey => $answer){
                $rating_max += $answer['Question']['scale'];
                $rating_real += $answer['rating'];
                $count_answers ++;
            }

            if(!empty($count_answers) && !empty($rating_real) && !empty($rating_max)){
                $score_max = $rating_max/$count_answers;
                $score_real = $rating_real/$count_answers;
                $gsi = round($score_real/$score_max*10, 1);
                $comments[$key]['Guest']['gsi'] = $gsi;
                unset($comments[$key]['Answer']);
            } else{
                unset($comments[$key]);
            }
        }
        return $comments;
    }


    /**
    * get a complete widget-record by its hash including
    * restructured contained widgetelments
    * so it is prepared for displaying
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_hash
    * @return mixed $widget
    */
    public function getByHash($widget_hash = null){
        if(!$widget_hash){
            return false;
        }

        $widget_hash = h(trim(strip_tags($widget_hash)));
        if(!$this->findByHash($widget_hash)){
            return false;
        }

        //find the widget and its associated Host and WidgetElements
        $widget = $this->find('first', array(
            'conditions' => array(
                'Widget.deleted' => 0,
                'Widget.hash' => $widget_hash,
                'Widget.status' => 1
            ),
            'contain' => array(
                'Host' => array(
                    'fields' => array(
                        'Host.id',
                        'Host.name',
                        'Host.logo',
                    )
                ),
                'WidgetElement' => array(
                    'fields' => array(
                        'type',
                        'param'
                    )
                )
            ),
            'fields' => array(
                'Widget.account_id',
                'Widget.poll_id',
                'Widget.name',
                'Widget.period',
                'Widget.format',
                'Widget.width',
                'Widget.height',
                'Widget.style'
            )
        ));

        /*
        * build WidgetElement fields into the Widget-array;
        * if a WidgetElement with comments exists, copy the definition 
        * from the param field of the WidgetElement-array to the select_comment_count field of the Widget-array;
        * else if another WidgetElement exists, copy the WidgetElement-type as a key into the Widget-array and set the value to 1;
        * else (if a bogus WidgetElement is supplied) throw an error
        */
        $types = $this->getWidgetElementTypesKeys();
        foreach($widget['WidgetElement'] as $widget_element){
            if($widget_element['type'] == 'comment'){
                $widget['Widget']['select_comment_count'] = $widget_element['param'];
            } elseif(in_array($widget_element['type'], $types)){
                $widget['Widget'][$widget_element['type']] = 1;
            } else{
                throw new NotFoundException();
            }
        }

        //check if WidgetElements are set and get the data
        if(isset($widget['Widget']['gsi']) && $widget['Widget']['gsi'] == 1){
            $widget['Widget']['gsi'] = $this->getGsi($widget['Widget']['period'], $widget['Widget']['poll_id']);
        }

        if(isset($widget['Widget']['ratinglabel']) && $widget['Widget']['ratinglabel'] == 1){
            $gsi = $this->getGsi($widget['Widget']['period'], $widget['Widget']['poll_id']);
            $widget['Widget']['ratinglabel'] = $this->getReviewlabel($gsi);
        }

        if(isset($widget['Widget']['ratingcount']) && $widget['Widget']['ratingcount'] == 1){
            $widget['Widget']['ratingcount'] = $this->getRatingCount($widget['Widget']['period'], $widget['Widget']['poll_id']);
        }

        if(isset($widget['Widget']['trend']) && $widget['Widget']['trend'] == 1){
            $widget['Widget']['trend'] = $this->getTrend($widget['Widget']['account_id'], $widget['Widget']['period'], $widget['Widget']['poll_id']);
        }

        if(isset($widget['Widget']['select_comment_count'])){
            $widget['Widget']['comments'] = $this->getComments($widget['Widget']['select_comment_count'], $widget['Widget']['period'], $widget['Widget']['poll_id']);
        }

        //delete the WidgetElement-array (data was copied to Widget-array)
        if(isset($widget['WidgetElement'])){
            unset($widget['WidgetElement']);
        }

        //return the data and increase the viewcount of the widget by one
        if(!empty($widget)){ 
            $this->id = $widget['Widget']['id'];
            $this->saveField('views', (int)$this->field('views') + 1);
            return $widget; 
        } else{
            return false;
        }
    }


    /**
    * check if a widget excists with the given hash
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param int $widget_hash
    * @return boolean
    */
    private function findByHash($widget_hash = null){
        if(!$widget_hash){
            return false;
        }

        $widget = $this->find('first', array(
            'conditions' => array(
                'Widget.deleted' => 0,
                'Widget.hash' => $widget_hash,
                'Widget.status' => 1
            ),
            'fields' => array(
                'id'
            )
        ));

        if(!empty($widget)){ 
            return true; 
        } else{
            return false;
        }
    }


    /**
    * get a given number/type of comments for a poll in a given period of time
    * collect the needed data and calculate the gsi 
    * and order comments with their gsi by the type selected
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param string $comment_count
    * @param string $period
    * @param int $poll_id
    * @return array $comments
    */
    private function getComments($comment_count = null, $period = null, $poll_id = null){
        if(!$comment_count || !$period || !$poll_id){
            return false;
        }

        $start = $this->getStartDate($period, $poll_id);
        $today = date('Y-m-d');
        
        //if its last10 or last5 comments enter here
        if(strpos($comment_count, 'last') !== false){
            //limit query to 5 or 10
            $limit = str_replace('last', '', $comment_count);
            
            //find the comments and its ratingvalues and order them by date
            $comments = $this->Poll->Guest->find('all', array(
                'conditions' => array(
                    'Guest.poll_id' => $poll_id,
                    'DATE(Guest.created) >=' => $start,
                    'DATE(Guest.created) <=' => $today,
                    'Guest.status' => 1
                ),
                'contain' => array(
                    'Answer' => array(
                        'conditions' => array(
                            'Answer.status' => 1
                        ),
                        'fields' => array(
                            'Answer.rating'
                        ),
                        'Question' => array(
                            'scale'
                        )
                    )
                ),
                'fields' => array(
                    'id',
                    'comment_customer',
                    'name',
                    'ip',
                    'created'
                ),
                'order' => array(
                    'Guest.created' =>'DESC',
                    'Guest.id' => 'DESC'
                ),
                'limit' => $limit
            ));
            
            //calculate the gsi for each guest
            $comments = $this->calculateGsiForComments($comments);
            
            //if no comments are in the database set a gsi of zero
            if(empty($comments)){
                $comments[0]['Guest']['gsi'] = 0;
            }

            return $comments;
        }

        //if its top10 or top5 comments enter here
        if(strpos($comment_count, 'top') !== false){
            //limit query to 5 or 10
            $top = str_replace('top', '', $comment_count);

            //find the comments and its ratingvalues
            $comments = $this->Poll->Guest->find('all', array(
                'conditions' => array(
                    'Guest.poll_id' => $poll_id,
                    'DATE(Guest.created) >=' => $start,
                    'DATE(Guest.created) <=' => $today,
                    'Guest.status' => 1
                ),
                'contain' => array(
                    'Answer' => array(
                        'conditions' => array(
                            'Answer.status' => 1
                        ),
                        'fields' => array(
                            'Answer.rating',
                            'Answer.status'
                        ),
                        'Question' => array(
                            'scale'
                        )
                    )
                ),
                'fields' => array(
                    'id',
                    'comment_customer',
                    'name',
                    'created'
                ),
            ));

            //calculate the gsi for each guest
            $comments = $this->calculateGsiForComments($comments);

            //sort the comments by gsi, best first, cut array depending on amount in $top 
            //so only the needed amount of gsis are in the array
            if(!empty($comments)){
                $result = Set::sort($comments, '{n}.Guest.gsi', 'desc');
                $comments = $result;
                $comments = array_slice($comments, 0, $top);
            } else{
                //if no comments are in the database set a gsi of zero
                $comments[0]['Guest']['gsi'] = 0;
            }

            return $comments;
        }
        
        return false;
    }


    /**
    * get the gsi for a poll in a given period of time
    * by calculating the ratings of the answers
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param string $period
    * @param int $poll_id
    * @return int $gsi
    */
    private function getGsi($period = null, $poll_id = null){
        if(!$period || !$poll_id){
            return false;
        }

        $start = $this->getStartDate($period, $poll_id);
        $today = date('Y-m-d');
        
        //find all answers for the given poll_id with the scales contained for the rating
        $answers = $this->Poll->Answer->find('all', array(
            'conditions' => array(
                'Answer.poll_id' => $poll_id,
                'DATE(Answer.created) >=' => $start,
                'DATE(Answer.created) <=' => $today,
                'Answer.status' => 1
            ),
            'contain' => array(
                'Question' => array(
                    'scale'
                )
            ),
            'fields' => array(
                'id',
                'guest_id',
                'question_id',
                'rating'
            )
        ));

        $rating_max     = 0;
        $rating_real    = 0;
        $count_answers  = 0;

        //sum up the answers, scale and ratings given
        if(!empty($answers)){
            foreach($answers as $answer){
                $count_answers++;
                $rating_max += $answer['Question']['scale'];
                $rating_real += $answer['Answer']['rating'];
            }
        }

        //calculate the GSI from the sums above
        if(!empty($count_answers) && !empty($rating_real) && !empty($rating_max)){
            $score_max = $rating_max/$count_answers;
            $score_real = $rating_real/$count_answers;
            $gsi = round($score_real/$score_max*10, 1);
        }

        //return the calculated GSI or zero
        if(!empty($gsi)){ 
            return $gsi;
        } else{
            return 0;
        }
    }


    /**
    * get the quantity of ratings for a poll in a given period of time
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param string $period
    * @param int $poll_id
    * @return int $comment_count
    */
    private function getRatingCount($period = null, $poll_id = null){
        if(!$period || !$poll_id){
            return false;
        }

        $start = $this->getStartDate($period, $poll_id);
        $today = date('Y-m-d');

        //count the Answers given for the given Poll, group it by the guest_id so every guest only counts ones
        $comment_count = $this->Poll->Answer->find('count', array(
            'conditions' => array(
                'Answer.poll_id' => $poll_id,
                'DATE(Answer.created) >=' => $start,
                'DATE(Answer.created) <=' => $today,
                'Answer.status' => 1
            ),
            'group' => array(
                'guest_id'
            )
        ));

        //return the count if one exists or else return the string 'No data'
        if(!empty($comment_count)){
            return $comment_count;    
        } else{
            //$comment_count = 'No data';
            $comment_count = 0;
            return $comment_count;
        }
        
        return false;
    }


    /**
    * translate the numeric gsi value into the text value incl. the html tag for formating
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param int $gsi
    * @return string html-data
    */
    private function getReviewlabel($gsi = null){
        $gsi = round(intval($gsi));
        $ratings_in_words = $this->getRatingsInWords();

        if(isset($ratings_in_words[$gsi]['text']) && isset($ratings_in_words[$gsi]['label'])){
            return '<small class="text-center label label-'.$ratings_in_words[$gsi]['label'].' gsi-base">'.$ratings_in_words[$gsi]['text'].'</small>';
        } else{
            return false;
        }
    }


    /**
    * get the trend of a poll in a given period of time
    * and re-structure the data for the view
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param int $account_id
    * @param string $period
    * @param int $poll_id
    * @return mixed data $result
    */
    private function getTrend($account_id = null, $period = null, $poll_id = null){
        if(!$account_id || !$period || !$poll_id){
            return false;
        }

        $start = $this->getStartDate($period, $poll_id);
        $today = date('Y-m-d');

        //set the group parameter (for the find following) and dateinfo for the given period
        if($period == 'week_1' || $period == 'month_1'){
            $group = 'date(Answer.created), month(Answer.created), year(Answer.created)';
            $dateinfo = 'day';
        } elseif($period == 'month_3' || $period == 'month_6' || $period == 'year_1'){
            $group = 'month(Answer.created), year(Answer.created)';
            $dateinfo = 'month';
        } elseif($period == 'all'){
            $group = 'year(Answer.created)';
            $dateinfo = 'year';
        } else{
            return false;
        }

        //find all answers for the given poll_id and period, sum the scales and ratings and count the questions, 
        //and group everything by the parameter(s) in the group variable
        $answers = $this->Poll->Answer->find('all', array(
            'conditions' => array(
                'Answer.poll_id' => $poll_id,
                'DATE(Answer.created) >=' => $start,
                'DATE(Answer.created) <=' => $today,
                'Answer.status' => 1
            ),
            'contain' => array(
                'Question' => array(
                    'fields' => array(
                        'sum(Question.scale) AS maxscore'
                    )
                )
            ),
            'fields' => array(
                'count(question_id) AS qcount',
                'sum(Answer.rating) AS realscore',
                'created'
            ),
            'group' => array(
                $group
            )
        ));

        //depending on the period create an array with the dateinfo as main array and the date as key and the gsi as the value for the inner array
        $result[$dateinfo] = null;
        foreach($answers as $key => $answer){
            if($period == 'week_1' || $period == 'month_1'){
                $result[$dateinfo][date('Y-m-d', strtotime($answers[$key]['Answer']['created']))] = round(($answer[0]['realscore']/$answer[0]['qcount'])/($answer[0]['maxscore']/$answer[0]['qcount'])*10, 1);
            } elseif($period == 'month_3' || $period == 'month_6' || $period == 'year_1'){
                $result[$dateinfo][date('Y-m', strtotime($answers[$key]['Answer']['created']))] = round(($answer[0]['realscore']/$answer[0]['qcount'])/($answer[0]['maxscore']/$answer[0]['qcount'])*10, 1);
            } else{
                $result[$dateinfo][date('Y', strtotime($answers[$key]['Answer']['created']))] = round(($answer[0]['realscore']/$answer[0]['qcount'])/($answer[0]['maxscore']/$answer[0]['qcount'])*10, 1);
            }
        }
        
        $datest = new DateTime($start);
        $dateto = new DateTime($today);
        $interval = $datest->diff($dateto);

        //for the given period check if there are enough entries in the array, if not fill up with date as key and zero as value
        if($period == 'week_1' || ($interval->y == 0 && $interval->m == 0 && $interval->d <= 8)){
            if(count($result[$dateinfo]) != 7){
                for($i = 6; $i >= 0; $i--){
                    if(!isset($result[$dateinfo][date('Y-m-d', strtotime($today.'-'.$i.'day'))])){
                        $result[$dateinfo][date('Y-m-d', strtotime($today.'-'.$i.'day'))] = 0;
                    }
                }
            }
        } elseif($period == 'month_1' || ($interval->y == 0 && $interval->m <= 1 && $interval->d <= 31)){
            if(count($result[$dateinfo]) != 31){
                for($i = 30; $i >= 0; $i--){
                    if(!isset($result[$dateinfo][date('Y-m-d', strtotime($today.'-'.$i.'day'))])){
                        $result[$dateinfo][date('Y-m-d', strtotime($today.'-'.$i.'day'))] = 0;
                    }
                }
            }
        } elseif($period == 'month_3' || ($interval->y == 0 && $interval->m <= 4 && $interval->d <= 31)){
            if(count($result[$dateinfo]) != 4){
                for($i = 3; $i >= 0; $i--){
                    if(!isset($result[$dateinfo][date('Y-m', strtotime($today.'-'.$i.'month'))])){
                        $result[$dateinfo][date('Y-m', strtotime($today.'-'.$i.'month'))] = 0;
                    }
                }
            }
        } elseif($period == 'month_6' || ($interval->y == 0 && $interval->m <= 7 && $interval->d <= 31)){
            if(count($result[$dateinfo]) != 7){
                for($i = 6; $i >= 0; $i--){
                    if(!isset($result[$dateinfo][date('Y-m', strtotime($today.'-'.$i.'month'))])){
                        $result[$dateinfo][date('Y-m', strtotime($today.'-'.$i.'month'))] = 0;
                    }
                }
            }
        } elseif($period == 'year_1' || ($interval->y <= 1 && $interval->m <= 0 && $interval->d <= 0)){
            if(count($result[$dateinfo]) != 13){
                for($i = 12; $i >= 0; $i--){
                    if(!isset($result[$dateinfo][date('Y-m', strtotime($today.'-'.$i.'month'))])){
                        $result[$dateinfo][date('Y-m', strtotime($today.'-'.$i.'month'))] = 0;
                    }
                }
            }
        } else{
            if(count($result[$dateinfo]) != $interval->y){
                for($i = $interval->y; $i >= 0; $i--){
                    if(!isset($result[$dateinfo][date('Y', strtotime($today.'-'.$i.'year'))])){
                        $result[$dateinfo][date('Y', strtotime($today.'-'.$i.'year'))] = 0;
                    }
                }
            }
        }
            
        //sort the array by the date key
        ksort($result[$dateinfo]);

        //return the build array or the string 'No data' (if no answers were found)
        if(!empty($result)){ 
            return $result;
        } else{
            //return 'No data';
            return 0;
        }
    }

}