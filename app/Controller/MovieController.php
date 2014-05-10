<?php

App::uses('AppController', 'Controller');

class MovieController extends AppController {

    /**
     * コンポーネント
     * @var array
     */
    public $components = ['Paginator', 'MovieUtil'];

    /**
     * モデル
     * @var array
     */
    public $uses = ['Movie', 'Cast', 'Tag', 'MoviesCast', 'MoviesTag'];

    /**
     * ページネート設定
     * @var array
     */
    public $paginate = [
        'limit' => 20,
        'order' => [
            'Movie.id' => 'asc'
        ],
        'paramType' => 'querystring'
    ];

    /**
     *
     */
    public function beforeFilter() {
        // ページネート設定
        $this->Paginator->settings = $this->paginate;
    }


    /**
     * 動画一覧
     */
    public function index() {

        $params = $this->_mergedCondition();

        $conditions = $this->_createConditions($params);

        $this->Paginator->settings['conditions'] = $conditions;

        $movies = $this->Paginator->paginate('Movie');

        // データ整形
        foreach($movies as &$movie) {
            $tags = $movie['Tag'];
            $casts = $movie['Cast'];
            $movie['Movie']['cast'] = $this->MovieUtil->createCastStr($casts);
            $movie['Movie']['tag'] = $this->MovieUtil->createTagStr($tags);
        }

        $this->set('movies', $movies);
    }


    /**
     * 動画追加
     */
    public function add() {

        $addData = [];
        $fileInValid = false;
        $errorMsg = null;
        $savedMovie = null;
        $castSplit = null;
        $tagSplit = null;


        $this->set('casts', $this->_getCastJsonData());

        $this->set('tags', $this->_getTagJsonData());

        if ($this->request->isPost()) {

            $data = $this->request->data;

            if (!empty($data)) {

                $addData['Movie']['title'] = $data['Movie']['title'];
                $addData['Movie']['file_name'] = $data['Movie']['file']['name'];

                $this->Movie->set($addData);

                if ($this->Movie->validates()) {

                    $fileInput = $data['Movie']['file'];

                    if (!is_uploaded_file($fileInput['tmp_name'])){

                        $fileInValid = true;
                        $errorMsg = VALID_FILE_REQUIRED;
                        $this->Movie->invalidate('file', $errorMsg);

                    }

                    $fileName = $fileInput['name'];
                    $uploadImgFullPath = WWW_ROOT.'movies/'.$fileName;
                    $tmpFileName = $fileInput['tmp_name'];

                    // 拡張子チェック
                    if(!preg_match('/(\.|\/)(mp4|mov)$/i', $fileName)) {

                        if (!$fileInValid) {
                            $fileInValid = true;
                            $errorMsg = VALID_FILE_EXTENSION;
                            $this->Movie->invalidate('file', $errorMsg);

                        }
                    }

                    // ファイルの移動
                    if(move_uploaded_file($tmpFileName, $uploadImgFullPath) && !$fileInValid) {

                        chmod($uploadImgFullPath, 0666);

                        // 保存
                        $dataSource = $this->Movie->getDataSource();
                        $dataSource->begin();

                        // movie
                        $savedMovie = $this->Movie->save();

                        if (!$savedMovie) {
                            $dataSource->rollback();
                            $this->Session->setFlash(LABEL_MOVIE . LABEL_TABLE . CONFIRM_MESSAGE_ADD_FAILURE, 'default',  ['class' => 'danger alert']);
                            return;

                        }

                        // cast
                        $savedCast = $this->_castSave($data['Movie']['cast']);
                        if (!$savedCast) {
                            $dataSource->rollback();
                            $this->Session->setFlash(LABEL_CAST . LABEL_TABLE. CONFIRM_MESSAGE_ADD_FAILURE, 'default',  ['class' => 'danger alert']);
                            return;
                        }

                        // tag
                        $savedTag = $this->_tagSave($data['Movie']['tag']);
                        if (!$savedTag) {
                            $dataSource->rollback();
                            $this->Session->setFlash(LABEL_TAG . LABEL_TABLE. CONFIRM_MESSAGE_ADD_FAILURE, 'default',  ['class' => 'danger alert']);
                            return;
                        }

                        // movie_cast
                        $savedMoviesCast = $this->_moviesCastSave($savedMovie, $savedCast);
                        if (!$savedMoviesCast) {
                            $dataSource->rollback();
                            $this->Session->setFlash(LABEL_MOVIE . LABEL_CAST . LABEL_TABLE. CONFIRM_MESSAGE_ADD_FAILURE, 'default',  ['class' => 'danger alert']);
                            return;
                        }

                        // movie_tag
                        $savedMoviesTag = $this->_moviesTagSave($savedMovie, $savedTag);
                        if (!$savedMoviesTag) {
                            $dataSource->rollback();
                            $this->Session->setFlash(LABEL_MOVIE . LABEL_TAG . LABEL_TABLE. CONFIRM_MESSAGE_ADD_FAILURE, 'default',  ['class' => 'danger alert']);
                            return;
                        }

                        $dataSource->commit();
                        $this->Session->setFlash(CONFIRM_MESSAGE_ADD_SUCCESS, 'flash_success', ['page_title' => LABEL_SUCCESS]);
                        $this->redirect('index');


                    } else {
                        $this->Session->setFlash(CONFIRM_MESSAGE_FILE_MOVE_ERROR, 'default',  ['class' => 'danger alert']);
                    }

                } else {
                    $this->Session->setFlash(CONFIRM_ERROR_MESSAGE, 'default',  ['class' => 'danger alert']);
                }

            } else {

                $this->Session->setFlash(CONFIRM_MESSAGE_NOT_SEND_DATA, 'default',  ['class' => 'danger alert']);

            }

        }

    }

    /**
     * 動画編集
     * @param $id
     */
    public function edit($id) {


        $this->set('casts', $this->_getCastJsonData());

        $this->set('tags', $this->_getTagJsonData());


        if ($this->request->isGet()) {

            $this->Movie->id = $id;
            $data = $this->Movie->read();

            // データ整形
            $tags = $data['Tag'];

            $casts = $data['Cast'];


            $data['Movie']['cast'] = $this->MovieUtil->createCastStr($casts);
            $data['Movie']['tag'] = $this->MovieUtil->createTagStr($tags);


            $this->request->data = $data;
        }

        if ($this->request->isPut()) {

            $data = $this->request->data;


            if (!empty($data)) {

                $editData['Movie']['id'] = $data['Movie']['id'];
                $editData['Movie']['title'] = $data['Movie']['title'];

                $this->Movie->set($editData);

                if ($this->Movie->validates()) {

                    // 保存
                    $dataSource = $this->Movie->getDataSource();
                    $dataSource->begin();

                    // movie
                    $savedMovie = $this->Movie->save();

                    if (!$savedMovie) {
                        $dataSource->rollback();
                        $this->Session->setFlash(LABEL_MOVIE . LABEL_TABLE . CONFIRM_MESSAGE_EDIT_FAILURE, 'default',  ['class' => 'danger alert']);
                        return;

                    }

                    // cast
                    $savedCast = $this->_castSave($data['Movie']['cast']);
                    if (!$savedCast) {
                        $dataSource->rollback();
                        $this->Session->setFlash(LABEL_CAST . LABEL_TABLE. CONFIRM_MESSAGE_EDIT_FAILURE, 'default',  ['class' => 'danger alert']);
                        return;
                    }

                    // tag
                    $savedTag = $this->_tagSave($data['Movie']['tag']);
                    if (!$savedTag) {
                        $dataSource->rollback();
                        $this->Session->setFlash(LABEL_TAG . LABEL_TABLE. CONFIRM_MESSAGE_EDIT_FAILURE, 'default',  ['class' => 'danger alert']);
                        return;
                    }

                    // movie_cast
                    $result = $this->MoviesCast->deleteAll(['MoviesCast.movie_id' => $savedMovie['Movie']['id']]);
                    if (!$result) {
                        $dataSource->rollback();
                        $this->Session->setFlash(LABEL_MOVIE . LABEL_CAST . LABEL_TABLE. CONFIRM_MESSAGE_DELETE_FAILURE, 'default',  ['class' => 'danger alert']);
                        return;
                    }
                    $savedMoviesCast = $this->_moviesCastSave($savedMovie, $savedCast);
                    if (!$savedMoviesCast) {
                        $dataSource->rollback();
                        $this->Session->setFlash(LABEL_MOVIE . LABEL_CAST . LABEL_TABLE. CONFIRM_MESSAGE_EDIT_FAILURE, 'default',  ['class' => 'danger alert']);
                        return;
                    }

                    // movie_tag
                    $result = $this->MoviesTag->deleteAll(['MoviesTag.movie_id' => $savedMovie['Movie']['id']]);
                    if (!$result) {
                        $dataSource->rollback();
                        $this->Session->setFlash(LABEL_MOVIE . LABEL_TAG . LABEL_TABLE. CONFIRM_MESSAGE_DELETE_FAILURE, 'default',  ['class' => 'danger alert']);
                        return;
                    }
                    $savedMoviesTag = $this->_moviesTagSave($savedMovie, $savedTag);
                    if (!$savedMoviesTag) {
                        $dataSource->rollback();
                        $this->Session->setFlash(LABEL_MOVIE . LABEL_TAG. LABEL_TABLE. CONFIRM_MESSAGE_EDIT_FAILURE, 'default',  ['class' => 'danger alert']);
                        return;
                    }

                    $dataSource->commit();
                    $this->Session->setFlash(CONFIRM_MESSAGE_EDIT_SUCCESS, 'flash_success', ['page_title' => LABEL_SUCCESS]);
                    $this->redirect('index');

                } else {
                    $this->Session->setFlash(CONFIRM_ERROR_MESSAGE, 'default',  ['class' => 'danger alert']);
                }
            }

        }


    }

    /**
     * 動画再生画面
     * @param $id
     */
    public function play($id) {

        $movie = $this->Movie->findById($id);

        $tags = $movie['Tag'];
        $casts = $movie['Cast'];

        $movie['Movie']['cast'] = $this->MovieUtil->createCastStr($casts);
        $movie['Movie']['tag'] = $this->MovieUtil->createTagStr($tags);

        $this->set('rootPath', MOVIE_ROOT_PATH);

        $this->set('movie', $movie);
    }

    /**
     * 検索条件をマージ
     * @return array
     */
    private function _mergedCondition() {

        $params = array_merge($this->passedArgs, $this->request->data);
        if (isset($this->request->data['Movie'])) {
            $this->request->query['page'] = 1;
        }

        $this->request->data = $params;
        return $params;
    }

    /**
     * 検索条件を作成して返します。
     * @param $data
     * @return array
     */
    private function _createConditions($data) {

        $conditions = [];
        $actMovieIds = [];
        $tagMovieIds = [];
        $movieIds = [];

        $conditions[] = [
            'Movie.deleted' => '0'
        ];

        if (isset($data['Movie'])) {

            $movie = $data['Movie'];

            if (isset($movie['title']) && $movie['title'] != '') {
                $conditions[] = [
                    'Movie.title LIKE' => '%'.$movie['title'].'%'
                ];
            }

            if (isset($movie['cast']) && $movie['cast'] != '') {

                $actMovieIds = $this->_createCastConditions($movie['cast']);

            }

            if (isset($movie['tag']) && $movie['tag'] != '') {

                $tagMovieIds = $this->_createTagConditions($movie['tag']);
            }

            $movieIds = $this->_mergedSearchMovieIds($actMovieIds, $tagMovieIds);

            if (count($movieIds) > 0) {
                $conditions[] = [
                    'Movie.id' => $movieIds
                ];
            }
        }

        return $conditions;
    }

    /**
     * 出演者の検索条件を作成して返します。
     * @param $param
     * @return array
     */
    private function _createCastConditions($param) {

        $result = [];
        $castConditions = [];
        $castIds = [];

        // 一度、タグをカンマ区切り分 like検索
        $casts = $this->_splitData($param);

        foreach($casts as $cast) {
            $castConditions['or'][] = [
                'Cast.name LIKE' => '%'.$cast.'%'
            ];
        }
        $castSearch = $this->Cast->find('all',[
            'conditions' => $castConditions
        ]);

        // 検索でmovies_tagを検索
        foreach($castSearch as $cast) {
            $castIds[] = $cast['Cast']['id'];
        }
        $moviesCastSearch = $this->MoviesCast->find('all', [
            'conditions' => [
                'MoviesCast.cast_id' => $castIds
            ]
        ]);

        // movies_castsの結果のmovie_idをinで検索
        foreach($moviesCastSearch as $moviesCast) {
            $result[] = $moviesCast['MoviesCast']['movie_id'];
        }

        return $result;
    }

    /**
     * タグの検索条件を作成して返します。
     * @param $param
     * @return array
     */
    private function _createTagConditions($param) {

        $result = [];
        $tagsConditions = [];
        $tagIds = [];

        // 一度、タグをカンマ区切り分 like検索
        $tags = $this->_splitData($param);

        foreach($tags as $tag) {
            $tagsConditions['or'][] = [
                'Tag.name LIKE' => '%'.$tag.'%'
            ];
        }
        $tagSearch = $this->Tag->find('all',[
            'conditions' => $tagsConditions
        ]);

        // 検索でmovies_tagを検索
        foreach($tagSearch as $tag) {
            $tagIds[] = $tag['Tag']['id'];
        }
        $moviesTagSearch = $this->MoviesTag->find('all', [
            'conditions' => [
                'MoviesTag.tag_id' => $tagIds
            ]
        ]);

        // movies_tagの結果のmovie_idをinで検索
        foreach($moviesTagSearch as $moviesTag) {
            $result[] = $moviesTag['MoviesTag']['movie_id'];
        }

        return $result;
    }

    /**
     * 出演者の一覧Jsonデータを作成して返します。
     * @return array
     */
    private function _getCastJsonData() {

        $castJsonData = [];

        $casts = $this->Cast->find('all', [
            'recursive' => -1,
            'conditions' => [
                'Cast.deleted' => 0
            ]
        ]);

        foreach($casts as $cast) {
            $data = [];
            $data['id'] = $cast['Cast']['id'];
            $data['label'] = $cast['Cast']['name'];
            $data['value'] = $cast['Cast']['name'];
            $castJsonData[] = $data;
        }

        return $castJsonData;
    }

    /**
     * タグの一覧Jsonデータを作成して返します。
     * @return array
     */
    private function _getTagJsonData() {

        $tagsJsonData = [];

        $tags = $this->Tag->find('all', [
            'recursive' => -1,
            'conditions' => [
                'Tag.deleted' => 0
            ]
        ]);

        foreach($tags as $tag) {
            $data = [];
            $data['id'] = $tag['Tag']['id'];
            $data['label'] = $tag['Tag']['name'];
            $data['value'] = $tag['Tag']['name'];
            //$data = $tag['Tag'];
            $tagsJsonData[] = $data;
        }

        return $tagsJsonData;
    }


    /**
     * 出演者の保存処理
     * @param $data
     * @return array|bool
     */
    private function _castSave($data) {

        $result = false;
        $addCastData = [];
        $savedCast = [];

        $castsSplit = $this->_splitData($data);

        foreach($castsSplit as $name) {
            $tmpData = null;
            if ($name != '') {
                $tmpData = $this->Cast->find('first', [
                    'recursive' => -1,
                    'conditions' => [
                        'Cast.deleted' => 0,
                        'Cast.name' => $name,
                    ]
                ]);

                if (!$tmpData) {
                    $tmpData = [];
                    $tmpData['Cast']['name'] = $name;
                    $addCastData[] = $tmpData;
                } else {
                    $savedCast[] = $tmpData;
                }
            }
        }

        if (count($addCastData) > 0) {

            foreach($addCastData as $tmpData) {
                $savedData = null;
                $this->Cast->create($tmpData);
                $savedData = $this->Cast->save();
                if ($savedData) {
                    $savedCast[] = $savedData;
                    $result = $savedCast;
                } else {
                    break;
                }
            }
        } else {
            $result = $savedCast;
        }

        return $result;
    }


    /**
     * タグの保存処理
     * @param $data
     * @return array|bool
     */
    private function _tagSave($data) {

        $result = false;
        $addTagData = [];
        $savedTag = [];

        $tagSplit = $this->_splitData($data);

        foreach($tagSplit as $name) {
            $tmpData = null;
            if ($name != '') {
                $tmpData = $this->Tag->find('first', [
                    'recursive' => -1,
                    'conditions' => [
                        'Tag.deleted' => 0,
                        'Tag.name' => $name,
                    ]
                ]);

                if (!$tmpData) {
                    $tmpData = [];
                    $tmpData['Tag']['name'] = $name;
                    $addTagData[] = $tmpData;
                } else {
                    $savedTag[] = $tmpData;
                }
            }
        }

        if (count($addTagData) > 0) {
            foreach($addTagData as $tmpData) {
                $savedData = null;
                $this->Tag->create($tmpData);
                $savedData = $this->Tag->save();
                if ($savedData) {
                    $savedTag[] = $savedData;
                    $result = $savedTag;
                } else {
                    break;
                }
            }
        } else {
            $result = $savedTag;
        }

        return $result;

    }

    /**
     * 動画、出演者関連テーブルの保存処理
     * @param $savedMovie
     * @param $savedCast
     * @return array|bool
     */
    private function _moviesCastSave($savedMovie, $savedCast) {

        $result = false;
        $savedData = null;
        $savedMoviesCast = [];

        foreach($savedCast as $castData) {
            $insData = [];
            $insData['MoviesCast']['movie_id'] = $savedMovie['Movie']['id'];
            $insData['MoviesCast']['cast_id'] = $castData['Cast']['id'];
            $this->MoviesCast->create($insData);
            $savedData = $this->MoviesCast->save();
            if ($savedData) {
                $savedMoviesCast[] = $savedData;
                $result = $savedMoviesCast;
            } else {
                break;
            }
        }

        return $result;
    }

    /**
     * 動画、タグ関連テーブルの保存処理
     * @param $savedMovie
     * @param $savedTag
     * @return array|bool
     */
    private function _moviesTagSave($savedMovie, $savedTag) {

        $result = false;
        $savedData = null;
        $savedMoviesTag = [];

        foreach($savedTag as $tagData) {
            $insData = [];
            $insData['MoviesTag']['movie_id'] = $savedMovie['Movie']['id'];
            $insData['MoviesTag']['tag_id'] = $tagData['Tag']['id'];
            $this->MoviesTag->create($insData);
            $savedData = $this->MoviesTag->save();
            if ($savedData) {
                $savedMoviesTag[] = $savedData;
                $result = $savedMoviesTag;
            } else {
                break;
            }
        }

        return $result;
    }

    private function _mergedSearchMovieIds($casts = [], $tags = []) {

        $large = count($casts) > count($tags) ? $casts : $tags;
        $small = count($casts) <= count($tags) ? $casts : $tags;
        $merged = [];


        foreach($large as $l) {
            foreach($small as $s) {
                if($s == $l) {
                    $merged[] = $s;
                }
            }
        }
        return $merged;

    }

    /**
     * カンマ区切りの文字列をトリムして配列で返します。
     * @param array $data
     * @return array
     */
    private function _splitData($data = []) {

        $result = explode(',', $data);

        array_walk($result, function (&$value) {
            $value = trim($value);
        });

        return $result;
    }

}