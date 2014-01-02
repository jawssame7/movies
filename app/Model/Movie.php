<?php

App::uses('AppModel', 'Model');

class Movie extends AppModel {

    public $name = 'Movie';

    public $hasAndBelongsToMany = [
        'Tag' => [
            'className'              => 'Tag',
            'joinTable'              => 'movies_tags',
            'foreignKey'             => 'movie_id',
            'associationForeignKey'  => 'tag_id',
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
        ],
        'Cast' => [
            'className'              => 'Cast',
            'joinTable'              => 'movies_casts',
            'foreignKey'             => 'movie_id',
            'associationForeignKey'  => 'cast_id',
            'unique'                 => false,
            'conditions'             => '',
            'fields'                 => '',
            'order'                  => '',
            'limit'                  => '',
            'offset'                 => '',
            'finderQuery'            => '',
            'deleteQuery'            => '',
            'insertQuery'            => '',
            'with'                   => 'MoviesCast'
        ],
    ];

    public $validate = [
        'title' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => VALID_TITLE_REQUIRED,
            ]
        ]
    ];

}