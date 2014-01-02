<?php

class CastController extends AppController {

    public $components = ['Paginator', 'MovieUtil'];

    public $uses = ['Movie', 'Cast', 'Tag', 'MoviesCast', 'MoviesTag'];

    public $paginate = [
        'limit' => 20,
        'order' => [
            'Cast.id' => 'asc'
        ]
    ];


    public function index() {

        $this->Paginator->settings = $this->paginate;

        $conditions = $this->_createConditions($this->request->data);

        $this->Paginator->settings['conditions'] = $conditions;

        $cast = $this->Paginator->paginate('Cast');

        $this->set('casts', $cast);

    }

    public function add() {

        if ($this->request->isPost()) {

            $data = $this->request->data;

            $this->Cast->create($data);

            if ($this->Cast->validates()) {

                $dataSource = $this->Cast->getDataSource();
                $dataSource->begin();

                if ($this->Cast->save()) {
                    $dataSource->commit();
                    $this->Session->setFlash(CONFIRM_MESSAGE_ADD_SUCCESS, 'flash_success', ['page_title' => LABEL_SUCCESS]);
                    $this->redirect('index');
                } else {
                    $dataSource->rollback();
                    $this->Session->setFlash(LABEL_CAST . LABEL_TABLE. CONFIRM_MESSAGE_ADD_FAILURE, 'default',  ['class' => 'danger alert']);
                    return;
                }

            } else {
                $this->Session->setFlash(CONFIRM_ERROR_MESSAGE, 'default',  ['class' => 'danger alert']);
            }

        }
    }

    public function edit($id) {

        if ($this->request->isGet()) {

            $this->Cast->id = $id;

            $this->request->data = $this->Cast->read();

        }

        if ($this->request->isPut()) {

            $data = $this->request->data;

            $this->Cast->set($data);

            if ($this->Cast->validates()) {

                $dataSource = $this->Cast->getDataSource();
                $dataSource->begin();

                if ($this->Cast->save()) {
                    $dataSource->commit();
                    $this->Session->setFlash(CONFIRM_MESSAGE_EDIT_SUCCESS, 'flash_success', ['page_title' => LABEL_SUCCESS]);
                    $this->redirect('index');
                } else {
                    $dataSource->rollback();
                    $this->Session->setFlash(LABEL_CAST . LABEL_TABLE. CONFIRM_MESSAGE_EDIT_FAILURE, 'default',  ['class' => 'danger alert']);
                    return;
                }

            } else {
                $this->Session->setFlash(CONFIRM_ERROR_MESSAGE, 'default',  ['class' => 'danger alert']);
            }
        }

    }

    public function delete($id) {

        if ($this->request->isGet()) {

            $this->Cast->id = $id;

            $data = $this->Cast->read();

            $data['Cast']['deleted'] = 1;

            $this->Cast->set($data);

            if ($this->Cast->validates()) {

                $dataSource = $this->Cast->getDataSource();
                $dataSource->begin();

                if ($this->Cast->save()) {
                    $dataSource->commit();
                    $this->Session->setFlash(CONFIRM_MESSAGE_DELETE_SUCCESS, 'flash_success', ['page_title' => LABEL_SUCCESS]);
                    $this->redirect('index');
                } else {
                    $dataSource->rollback();
                    $this->Session->setFlash(LABEL_CAST . LABEL_TABLE. CONFIRM_MESSAGE_DELETE_FAILURE, 'default',  ['class' => 'danger alert']);
                    return;
                }

            } else {
                $this->Session->setFlash(LABEL_ERROR_DELETE_MESSAGE, 'default',  ['class' => 'danger alert']);
                $this->redirect('index');
            }

        }

    }

    private function _createConditions($data) {

        $conditions = [];

        $conditions[] = [
            'Cast.deleted' => '0'
        ];

        if (isset($data['Cast'])) {
            $name = $data['Cast']['name'];
            $conditions[] = [
                'Cast.name LIKE' => '%'.$name.'%'
            ];
        }

        return $conditions;
    }

}