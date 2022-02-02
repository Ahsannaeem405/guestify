<?php
class DraftsController extends AppController {

    public $name = 'Drafts';

    public $uses = array('Draft');

    /**
    * add a draft via AJAX
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function addDraft() {
        
        if($this->RequestHandler->isAjax()) {

            $data = $this->params->query;

            if($this->Draft->add($data)) {
                $this->Session->setFlash(__('The draft was saved!', true), 'default', array('class' => 'alert alert-success'));
                Configure::write('debug', 0);
                $this->autoRender = false;
                return $this->Draft->id;
            } else {
                $result = $this->Draft->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }
    }


    /**
    * add a new poll draft
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function admin_add() {

        // if($this->RequestHandler->isPost()) {

        //     if($this->Draft->add($data)) {
        //         $this->Session->setFlash(__('The draft was saved!', true), 'default', array('class' => 'alert alert-success'));
        //         $this->redirect(array('action' => 'admin_view', $this->Draft->id));
        //     } else {
        //         $this->Session->setFlash(__('The draft could not be saved!', true), 'default', array('class' => 'alert alert-danger'));
        //     }
        // }


        // $draft           = $this->Draft->getDraftById(1);
        // $scale_selected  = $this->Draft->getMaxScale(1);
        // $draft = array();
        // $scale_selected = 4;

        // $this->Session->write('DraftsAdd.Draft', $draft);
        // $this->Session->write('DraftsAdd.locale_selected', 'eng');
        // $this->Session->write('DraftsAdd.title', $draft['Draft']['name_eng']);
        // $this->Session->write('DraftsAdd.scale_selected', $scale_selected);

        $locale = 'eng';
        $this->set(compact('locale'));
    }


    /**
    * delete a draft
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $draft_id
    * @return void
    */
    public function admin_delete($draft_id = null) {
        if(!$draft_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $this->Draft->id = $draft_id;

        if(!$this->Draft->exists()) {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        if($this->Draft->saveField('deleted', 1)) {
            $this->Session->setFlash(__('The draft was deleted!', true), 'default', array('class' => 'alert alert-success'));
            $this->redirect(array('action' => 'admin_index'));
        } else {
            $this->Session->setFlash(__('The draft could not be deleted!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }
    }


    /**
    * edit a poll draft
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function admin_edit($draft_id = null, $locale = null) {

        if(!$locale) {
            $locale = 'eng';
        }


        $draft = $this->Session->read('DraftsEdit.Draft');
        if(empty($draft)) {
            $draft = $this->Draft->getDraftById($draft_id);
        } 

        $scale_selected  = $this->Draft->getMaxScaleFromDataset($draft);

        $this->Session->write('DraftsEdit.Draft', $draft);
        $this->Session->write('DraftsEdit.locale_selected', $locale);
        $this->Session->write('DraftsEdit.title', $draft['Draft']['name_'.$locale]);
        $this->Session->write('DraftsEdit.scale_selected', $scale_selected);

        $this->set(compact('draft', 'locale'));

        // pr($draft);
        // exit;
    }

    /**
    * list all poll drafts
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function admin_index() {

        $conditions = array();
        $conditions['Draft.deleted'] = 0;
        $conditions['Draft.status'] = array(0, 1);

        $this->Draft->virtualFields = array(
            'poll_count' => 'SELECT COUNT(*) FROM polls as Poll WHERE Poll.draft_id = Draft.id AND Poll.deleted = 0'
        );

        # paginate the list with manual options
        $this->paginate = array(
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
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'Draft.id ASC'
        );
        $drafts = $this->paginate('Draft');

        $statuses = $this->Draft->getStatuses();

        $this->set(compact('drafts', 'statuses'));

        $this->params['navtabs.main'] = 'system';
    }

    /**
    * view a complete draft
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $draft_id
    * @return void
    */
    public function admin_view($draft_id = null) {

        if($this->RequestHandler->isPost()) {
            $data = $this->data;
            if(isset($data['Draft']['locale']) && !empty($data['Draft']['locale'])) {
                $this->Session->write('Drafts.locale', $data['Draft']['locale']);
            }
            if(isset($data['Draft']['theme_id']) && !empty($data['Draft']['theme_id'])) {
                $this->Session->write('Drafts.theme_id', $data['Draft']['theme_id']);
            }
            if(isset($data['Draft']['color']) && !empty($data['Draft']['color'])) {
                $this->Session->write('Drafts.color', $data['Draft']['color']);
            }
        }

        $locale = $this->Session->read('Drafts.locale');
        if(empty($locale)) {
            $this->Session->write('Drafts.locale', 'deu');
        }
        $theme_id = $this->Session->read('Drafts.theme_id');
        if(empty($theme_id)) {
            $this->Session->write('Drafts.theme_id', 1);
        }
        $color = $this->Session->read('Drafts.color');
        if(empty($color)) {
            $this->Session->write('Drafts.color', '000');
        }

        $draft      = $this->Draft->getDraftById($draft_id);
        $max_scale  = $this->Draft->getMaxScale($draft_id);
        $statuses   = $this->Draft->getStatuses();

        $Poll = ClassRegistry::init('Poll');
        $options_themes = $Poll->getThemes();

        $this->set(compact('draft', 'max_scale', 'statuses', 'options_themes'));

        $this->params['navtabs.main'] = 'system';

    }

    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
    * cancel a draft edit
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $draft_id
    * @return void
    */
    public function cancelDraftEdit($draft_id) {
        $this->Session->write('DraftsEdit', '');
        $this->redirect(array('action' => 'admin_view', $draft_id));
    }

    /**
    * creator: add a group to a given draft
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function creatorGroupAdd() {
        
        if($this->RequestHandler->isAjax()) {

            $draft_id = $this->params->query('draft_id');
            $position = $this->Draft->getNextGroupPosition($draft_id);

            $group = array();
            $group['draft_id'] = $draft_id;
            $group['name_deu'] = __('Click here to edit...', true);
            $group['name_eng'] = __('Click here to edit...', true);
            $group['position'] = $position;

            $this->Draft->DraftsGroup->create();
            if($this->Draft->DraftsGroup->save($group)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode(true);
            } else {
                $result = $this->Draft->DraftsGroup->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }
    }

    /**
    * creator: delete a given group
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function creatorGroupDelete() {

        if($this->RequestHandler->isAjax()) {

            $group_id = $this->params->query('group_id');

            $this->Draft->DraftsGroup->id = $group_id;
            $draft_id = $this->Draft->DraftsGroup->field('draft_id');

            if($this->Draft->DraftsGroup->delete($group_id, false)) {

                $this->Draft->DraftsGroup->DraftsGroupsQuestion->deleteAll(array('DraftsGroupsQuestion.drafts_group_id' => $group_id), false);

                $this->Draft->reorderDraftGroups($draft_id);
                
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode(true);
            } else {
                $result = $this->Draft->DraftsGroup->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }
    }

    /**
    * edit a draft via AJAX
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function editDraft() {

        $data = $this->data;

        if($this->Draft->edit($data)) {

            $this->Session->write('DraftsEdit', '');

            $this->Session->setFlash(__('The draft was saved!', true), 'default', array('class' => 'alert alert-success'));
            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode(true);

        } else {

            $result = $this->Draft->invalidFields();
            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($result);

        }
    }

    /**
    * edit a draft via AJAX
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function quickSaveDraft() {

        $draft = $this->data;
        $this->Session->write('DraftsEdit.Draft', $draft);

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode(true);
    }

    /**
    * reset a draft via AJAX
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function resetDraft() {

        $draft = $this->Session->read('DraftsEdit.Draft');
        $this->Session->write('DraftsEdit.Draft', '');

        Configure::write('debug', 0);
        $this->autoRender = false;
        return true;
    }

}
