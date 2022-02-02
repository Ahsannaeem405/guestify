<?php
class Draft extends AppModel {

    public $name = 'Draft';

    public $displayField = 'name_eng';

    public $hasMany = array(
        'DraftsGroup'
    );

    public $actsAs = array(
        'Containable'
    );



    /**
    * add a poll-draft by given form-data
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function add($data = null) {

        $scale  = $data['Draft']['scale'];
        $locale = $data['Draft']['locale'];

        # first, create the draft record
        $record = array();
        $record['name_eng'] = $data['Draft']['name'];
        $record['name_deu'] = $data['Draft']['name'];
        $record['status'] = 0;

        # add some basic validation here!
        if(!isset($data['Draft']['name']) || empty($data['Draft']['name'])) {
            $this->invalidate('name', __('Please enter the name for your poll-draft!', true));
        }
        if(!isset($data['Draft']['locale']) || empty($data['Draft']['locale'])) {
            $this->invalidate('locale', __('Please select a locale!', true));
        }
        if(!isset($data['Draft']['status']) || ($data['Draft']['status'] == '')) {
            $this->invalidate('status', __('Please select a status!', true));
        }
        if(!isset($data['Draft']['scale']) || ($data['Draft']['scale'] == '')) {
            $this->invalidate('scale', __('Please select a scale!', true));
        }

        # check if at least one group exists
        if(!isset($data['Groups']) || empty($data['Groups'])) {
            $this->invalidate('groups_empty', '');
        } else {
            # check if all groups have at least one question 
            foreach($data['Groups'] as $key => $group) {
                if(!isset($group['Questions']) || empty($group['Questions'])) {
                    $this->invalidate('questions_empty', '');
                }
            }
        }

        if(!$this->validates()) {
            return false;
        }


        $this->create();
        if(!$this->save($record)) {
            return false;
        }

        # next, define all given groups
        $position_group = 1;
        foreach($data['Groups'] as $key => $group) {

            $record = array();
            $record['draft_id'] = $this->id;
            $record['name_eng'] = $group['Group']['name'];
            $record['name_deu'] = $group['Group']['name'];
            $record['position'] = $position_group;

            $this->DraftsGroup->create();
            $this->DraftsGroup->save($record);

            # within each group, define all given groups
            if(isset($group['Questions']) && !empty($group['Questions'])) {
                
                $position_question = 1;
                foreach($group['Questions'] as $key_question => $question) {

                    $record = array();
                    $record['draft_id']         = $this->id;
                    $record['drafts_group_id']  = $this->DraftsGroup->id;
                    $record['question_eng']     = $question['Question']['question'];
                    $record['question_deu']     = $question['Question']['question'];
                    $record['scale']            = $scale;
                    $record['position']         = $position_question;

                    $this->DraftsGroup->DraftsGroupsQuestion->create();
                    $this->DraftsGroup->DraftsGroupsQuestion->save($record);

                    $position_question++;
                }
            }

            $position_group++;
        }

        return true;
    }

    /**
    * edit a poll-draft by given form-data
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function edit($data = null) {

        # remap the EDITED draft dataset
        $draft_dataset = $data;

        $draft      = $data['Draft'];
        $this->id   = $draft['id'];

        $this->save($draft);
        

        $groups = $data['DraftsGroup'];

        # get all group/question ids from the EDITED draft dataset
        $group_ids      = array();
        $question_ids   = array();
        foreach($groups as $group) {
            array_push($group_ids, $group['id']);
            foreach($group['DraftsGroupsQuestion'] as $question) {
                array_push($question_ids, $question['id']);
            }
        }


        # get all group/question ids from the ORIGINAL draft dataset
        $draft_original = $this->getDraftById($draft['id']);
        $original_group_ids      = array();
        $original_question_ids   = array();        

        foreach($draft_original['DraftsGroup'] as $group) {
            array_push($original_group_ids, $group['id']);
            foreach($group['DraftsGroupsQuestion'] as $question) {
                array_push($original_question_ids, $question['id']);
            }
        }


        # now MATCH them to get all group/question ids that are no longer needed
        $throw_out_group_ids = array();
        $throw_out_question_ids = array();
        
        foreach($original_group_ids as $key => $group_id) {
            if(!in_array($group_id, $group_ids)) {
                array_push($throw_out_group_ids, $group_id);
            }
        }

        foreach($original_question_ids as $key => $question_id) {
            if(!in_array($question_id, $question_ids)) {
                array_push($throw_out_question_ids, $question_id);
            }
        }

        # delete all no more needed groups/questions (actually set deleted flag to 1)
        $this->DraftsGroup->updateAll(
            array(
                'DraftsGroup.deleted' => 1
            ),
            array(
                'DraftsGroup.id' => $throw_out_group_ids
            )
        );

        $this->DraftsGroup->DraftsGroupsQuestion->updateAll(
            array(
                'DraftsGroupsQuestion.deleted' => 1
            ),
            array(
                'DraftsGroupsQuestion.id' => $throw_out_question_ids
            )
        );


        foreach($draft_dataset['DraftsGroup'] as $group) {
            $questions = array();
            if(isset($group['DraftsGroupsQuestion'])) {
                $questions = $group['DraftsGroupsQuestion'];
                unset($group['DraftsGroupsQuestion']);
            }

            $group['draft_id'] = $draft['id'];

            if(!empty($group['id'])) {
                $this->DraftsGroup->id = $group['id'];
                $this->DraftsGroup->save($group);
            } else {
                $this->DraftsGroup->create();
                $this->DraftsGroup->save($group);
            }

            if(!empty($questions)) {
                foreach($questions as $question) {
                    $question['drafts_group_id'] = $this->DraftsGroup->id;
                    $question['draft_id'] = $draft['id'];
                    if(!empty($question['id'])) {
                        $this->DraftsGroup->DraftsGroupsQuestion->id = $question['id'];
                        $this->DraftsGroup->DraftsGroupsQuestion->save($question);
                    } else {
                        $this->DraftsGroup->DraftsGroupsQuestion->create();
                        $this->DraftsGroup->DraftsGroupsQuestion->save($question);
                    }
                }
            }
        }

        return true;
    }

    /**
    * get a complete draft record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $draft_id
    * @return mixed
    */
    public function getDraftById($draft_id = null) {
        if(!$draft_id) {
            return array();
        }

        $draft = $this->find('first', array(
            'contain' => array(
                'DraftsGroup' => array(
                    'conditions' => array(
                        'DraftsGroup.deleted' => 0
                    ),
                    'order' => array(
                        'DraftsGroup.position' => 'ASC'
                    ),
                    'DraftsGroupsQuestion' => array(
                        'conditions' => array(
                            'DraftsGroupsQuestion.deleted' => 0
                        ),
                        'order' => array(
                            'DraftsGroupsQuestion.position' => 'ASC'
                        )
                    )
                )
            ),
            'conditions' => array(
                'Draft.id' => $draft_id
            )
        ));

        return $draft;
    }

    /**
    * get an array of statuses
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getMaxScale($draft_id = null) {
        if(!$draft_id) {
            return 0;
        }

        $max = $this->DraftsGroup->DraftsGroupsQuestion->find('first', array(
            'conditions' => array(
                'DraftsGroupsQuestion.deleted' => 0
            ),
            'order' => array(
                'DraftsGroupsQuestion.scale' => 'DESC'
            )
        ));

        if(!empty($max)) {
            return $max['DraftsGroupsQuestion']['scale'];
        }

        return 4;
    }

    /**
    * get an array of statuses
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getMaxScaleFromDataset($draft = null) {
        if(!$draft) {
            return 4;
        }

        $max = 0;

        if(!isset($draft['DraftsGroup']) || empty($draft['DraftsGroup'])) {
            return 4;
        }
        
        foreach($draft['DraftsGroup'] as $group) {
            foreach($group['DraftsGroupsQuestion'] as $question) {
                if($question['scale'] > $max) {
                    $max = $question['scale'];
                }
            }
        }

        if(!empty($max)) {
            return $max;
        }

        return 4;
    }

    /**
    * get the next position for a group for a given draft
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $draft_id
    * @return int
    */
    public function getNextGroupPosition($draft_id = null) {

        $last = $this->DraftsGroup->find('first', array(
            'conditions' => array(
                'DraftsGroup.draft_id' => $draft_id
            ),
            'order' => array(
                'DraftsGroup.position' => 'DESC'
            )
        ));

        if(empty($last)) {
            return 1;
        }

        $position = $last['DraftsGroup']['position'];

        return $position + 1;
    }

    /**
    * get an array of statuses
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getStatuses() {
        return array(
            0 => __('inactive', true),
            1 => __('active', true),
            2 => __('archived', true)
        );
    }

    /**
    * reorder all groups of a given draft
    * => sort all existing ascending and
    * reset positions ascending 
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $draft_id
    * @return boolean
    */
    public function reorderDraftGroups($draft_id = null) {

        $groups = $this->DraftsGroup->find('all', array(
            'conditions' => array(
                'DraftsGroup.draft_id' => $draft_id
            ),
            'order' => array(
                'DraftsGroup.position' => 'ASC'
            )
        ));

        if(empty($groups)) {
            return false;
        }

        $position = 1;
        foreach($groups as $group) {
            $this->DraftsGroup->id = $group['DraftsGroup']['id'];
            $this->DraftsGroup->saveField('position', $position);
            $position++;
        }

        return true;
    }

}
