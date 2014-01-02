<?php

App::uses('AppModel', 'Model');

class Cast extends AppModel {

    public $name = 'Cast';

    public $hasAndBelongsToMany = [
        'Movie' => [
            'className'              => 'Movie',
            'joinTable'              => 'movies_cast',
            'foreignKey'             => 'cast_id',
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
            'with'                   => 'MoviesCast'
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