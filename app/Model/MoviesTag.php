<?php

App::uses('AppModel', 'Model');

class MoviesTag extends AppModel {

    public $name = 'MoviesTag';

    public $belongsTo = [
        'Movie' => [
            'className' => 'Movie',
            'foreignKey' => 'movie_id',
        ],
        'Tag' => [
            'className' => 'Tag',
            'foreignKey' => 'tag_id',
        ],
    ];
}