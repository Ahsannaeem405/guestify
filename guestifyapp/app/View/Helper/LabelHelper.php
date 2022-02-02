<?php
/*
*  Helper to decide wether a user is allowed to see
*  specified elements or not
*/ 
class LabelHelper extends Helper {

    public $helpers = array('Session');

    public function GsiLabel($gsi = null) {

        $gsi = round(intval($gsi));

        $Poll = ClassRegistry::init('Poll');
        $ratings_in_words = $Poll->getRatingsInWords();

        if(isset($ratings_in_words[$gsi]['text']) && isset($ratings_in_words[$gsi]['label'])) {
            return '<small class="text-center label label-'.$ratings_in_words[$gsi]['label'].' gsi-base">'.$ratings_in_words[$gsi]['text'].'</small>';
        } else {
            return $gsi;
        }
    }


}
