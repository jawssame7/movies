<?php


class MovieUtilComponent extends Component {

    public function createTagStr($tags = []) {

        $tmpTags = [];

        foreach($tags as $tag) {
            $tmpTags[] = $tag['name'];
        }

        return implode(',', $tmpTags);
    }

    public function createCastStr($casts = []) {

        $tmpCast = [];

        foreach($casts as $cast) {
            $tmpCast[] = $cast['name'];
        }

        return implode(',', $tmpCast);
    }

}