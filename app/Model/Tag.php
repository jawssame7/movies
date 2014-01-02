<?php

App::uses('AppModel', 'Model');

class Tag extends AppModel {

    public $name = 'Tag';

    public $hasAndBelongsToMany = [
        'Movie' => [
            'className'              => 'Movie',
            'joinTable'              => 'movies_tags',
            'foreignKey'             => 'tag_id',
            'associationForeignKey'  => 'movie_id',
            'unique'                 => false,
            'conditions'             => '',
            'fields'                 => '',
            'order'                  => '',
            'limit'                  => '',
            'offset'                 => '',
            'finderQuery'            => '',
            'deleteQuery'            => '',
            'insertQuery'            => '',
            'with'                   => 'MoviesTag'
        ]
    ];

    public $validate = [
        'name' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => VALID_NAME_REQUIRED,
            ]
        ]
    ];
}