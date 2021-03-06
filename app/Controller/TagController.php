<?php
class TagController extends AppController {

    /**
     * コンポーネント
     * @var array
     */
    public $components = ['Paginator', 'MovieUtil'];

    /**
     * モデル
     * @var array
     */
    public $uses = ['Movie', 'Cast', 'Tag', 'MoviesTag', 'MoviesTag'];

    /**
     * ページネート設定
     * @var array
     */
    public $paginate = [
        'limit' => 20,
        'order' => [
            'Tag.id' => 'asc'
        ]
    ];


    /**
     * タグ一覧
     */
    public function index() {

        $this->Paginator->settings = $this->paginate;

        $conditions = $this->_createConditions($this->request->data);

        $this->Paginator->settings['conditions'] = $conditions;
        
        $tags = $this->Paginator->paginate('Tag');

        $this->set('tags', $tags);

    }

    /**
     * タグ追加
     */
    public function add() {

        if ($this->request->isPost()) {

            $data = $this->request->data;

            $this->Tag->create($data);

            if ($this->Tag->validates()) {

                $dataSource = $this->Tag->getDataSource();
                $dataSource->begin();

                if ($this->Tag->save()) {
                    $dataSource->commit();
                    $this->Session->setFlash(CONFIRM_MESSAGE_ADD_SUCCESS, 'flash_success', ['page_title' => LABEL_SUCCESS]);
                    $this->redirect('index');
                } else {
                    $dataSource->rollback();
                    $this->Session->setFlash(LABEL_TAG . LABEL_TABLE. CONFIRM_MESSAGE_ADD_FAILURE, 'default',  ['class' => 'danger alert']);
                    return;
                }

            } else {
                $this->Session->setFlash(CONFIRM_ERROR_MESSAGE, 'default',  ['class' => 'danger alert']);
            }

        }
        
    }

    /**
     * タグ編集
     * @param $id
     */
    public function edit($id) {

        if ($this->request->isGet()) {

            $this->Tag->id = $id;

            $this->request->data = $this->Tag->read();

        }

        if ($this->request->isPut()) {

            $data = $this->request->data;

            $this->Tag->set($data);

            if ($this->Tag->validates()) {

                $dataSource = $this->Tag->getDataSource();
                $dataSource->begin();

                if ($this->Tag->save()) {
                    $dataSource->commit();
                    $this->Session->setFlash(CONFIRM_MESSAGE_EDIT_SUCCESS, 'flash_success', ['page_title' => LABEL_SUCCESS]);
                    $this->redirect('index');
                } else {
                    $dataSource->rollback();
                    $this->Session->setFlash(LABEL_TAG . LABEL_TABLE. CONFIRM_MESSAGE_EDIT_FAILURE, 'default',  ['class' => 'danger alert']);
                    return;
                }

            } else {
                $this->Session->setFlash(CONFIRM_ERROR_MESSAGE, 'default',  ['class' => 'danger alert']);
            }
        }

    }

    /**
     * タグ削除
     * @param $id
     */
    public function delete($id) {

        if ($this->request->isGet()) {

            $this->Tag->id = $id;

            $data = $this->Tag->read();

            $data['Tag']['deleted'] = 1;

            $this->Tag->set($data);

            if ($this->Tag->validates()) {

                $dataSource = $this->Tag->getDataSource();
                $dataSource->begin();

                if ($this->Tag->save()) {
                    $dataSource->commit();
                    $this->Session->setFlash(CONFIRM_MESSAGE_DELETE_SUCCESS, 'flash_success', ['page_title' => LABEL_SUCCESS]);
                    $this->redirect('index');
                } else {
                    $dataSource->rollback();
                    $this->Session->setFlash(LABEL_TAG . LABEL_TABLE. CONFIRM_MESSAGE_DELETE_FAILURE, 'default',  ['class' => 'danger alert']);
                    return;
                }

            } else {
                $this->Session->setFlash(LABEL_ERROR_DELETE_MESSAGE, 'default',  ['class' => 'danger alert']);
                $this->redirect('index');
            }

        }
    }

    /**
     * 検索条件を作成して返します。
     * @param $data
     * @return array
     */
    private function _createConditions($data) {

        $conditions = [];

        $conditions[] = [
            'Tag.deleted' => '0'
        ];

        if (isset($data['Tag'])) {
            $name = $data['Tag']['name'];
            $conditions[] = [
                'Tag.name LIKE' => '%'.$name.'%'
            ];
        }

        return $conditions;
    }

}
