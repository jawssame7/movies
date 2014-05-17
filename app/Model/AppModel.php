<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {


    public function castsTagsSearch($castsTagsCond = []) {

        $result = [];

        $castsTagSearchSQL = 'SELECT ';
        $castsTagSearchSQL .= '* ';
        $castsTagSearchSQL .= 'FROM ';
        $castsTagSearchSQL .= '    ( ';
        $castsTagSearchSQL .= '    SELECT ';
        $castsTagSearchSQL .= '        c.id AS cast_id, ';
        $castsTagSearchSQL .= '        mc.movie_id AS movie_id, ';
        $castsTagSearchSQL .= '        c.name AS cast_name';
        $castsTagSearchSQL .= '    FROM ';
        $castsTagSearchSQL .= '        casts c ';
        $castsTagSearchSQL .= '    INNER JOIN ';
        $castsTagSearchSQL .= '        movies_casts mc ';
        $castsTagSearchSQL .= '    ON ';
        $castsTagSearchSQL .= '        c.id = mc.cast_id ';
        $castsTagSearchSQL .= '    AND ';
        $castsTagSearchSQL .= '        c.deleted = 0 ';
        $castsTagSearchSQL .= '    ) ';
        $castsTagSearchSQL .= '    AS ';
        $castsTagSearchSQL .= '        mc ';
        $castsTagSearchSQL .= 'INNER JOIN ';
        $castsTagSearchSQL .= '    (';
        $castsTagSearchSQL .= '    SELECT ';
        $castsTagSearchSQL .= '        t.id AS tag_id, ';
        $castsTagSearchSQL .= '        mt.movie_id AS movie_id, ';
        $castsTagSearchSQL .= '        t.name AS tag_name ';
        $castsTagSearchSQL .= '    FROM ';
        $castsTagSearchSQL .= '        tags t';
        $castsTagSearchSQL .= '    INNER JOIN ';
        $castsTagSearchSQL .= '        movies_tags mt';
        $castsTagSearchSQL .= '    ON ';
        $castsTagSearchSQL .= '        t.id = mt.tag_id';
        $castsTagSearchSQL .= '    AND ';
        $castsTagSearchSQL .= '        t.deleted = 0 ';
        $castsTagSearchSQL .= '    ) ';
        $castsTagSearchSQL .= '    AS ';
        $castsTagSearchSQL .= '        mt ';
        $castsTagSearchSQL .= 'ON ';
        $castsTagSearchSQL .= 'mc.movie_id = mt.movie_id ';

        if (count($castsTagsCond) > 0) {

            $castsTagSearchSQL .= 'WHERE ';
            if (isset($castsTagsCond['cast_name'])) {
                $i = 0;
                $len = count($castsTagsCond['cast_name']);
                foreach($castsTagsCond['cast_name'] as $cast) {
                    if ($i == 0) {
                        $castsTagSearchSQL .= '( ';
                    }
                    $castsTagSearchSQL .= 'cast_name LIKE '. '\'' . $cast . '\''. ' ';
                    $i++;
                    if ($len != $i) {
                        $castsTagSearchSQL .= 'OR ';
                    }
                    if ($i == $len) {
                        $castsTagSearchSQL .= ') ';
                    }
                }
            }

            if (isset($castsTagsCond['cast_name']) && isset($castsTagsCond['tag_name'])) {
                $castsTagSearchSQL .= 'AND ';
            }

            if (isset($castsTagsCond['tag_name'])) {
                $i = 0;
                $len = count($castsTagsCond['tag_name']);
                foreach($castsTagsCond['tag_name'] as $tag) {
                    if ($i == 0) {
                        $castsTagSearchSQL .= '( ';
                    }
                    $castsTagSearchSQL .= 'tag_name LIKE '. '\'' . $tag . '\''. ' ';
                    $i++;
                    if ($len != $i) {
                        $castsTagSearchSQL .= 'OR ';
                    }
                    if ($i == $len) {
                        $castsTagSearchSQL .= ') ';
                    }
                }
            }
        }

        $castsTagSearchSQL .= 'ORDER BY mc.movie_id ASC ';


        $castsTags = $this->query($castsTagSearchSQL);

        foreach($castsTags as $castTag) {
            $mc = $castTag['mc'];
            $result[] = $mc['movie_id'];
        }


        return $result;

    }

}
