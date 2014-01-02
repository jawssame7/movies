<?php

App::uses('AppModel', 'Model');

class MoviesCast extends AppModel {

    public $name = 'MoviesCast';

    public $belongsTo = [
        'Movie' => [
            'className' => 'Movie',
            'foreignKey' => 'movie_id',
        ],
        'Cast' => [
            'className' => 'Cast',
            'foreignKey' => 'cast_id',
        ],
    ];
}