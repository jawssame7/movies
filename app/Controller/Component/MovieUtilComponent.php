<?php


class MovieUtilComponent extends Component {

    /**
     * タグの一覧からカンマ区切りの文字列を作成して返します。
     * @param array $tags
     * @return string
     */
    public function createTagStr($tags = []) {

        $tmpTags = [];

        foreach($tags as $tag) {
            $tmpTags[] = $tag['name'];
        }

        return implode(',', $tmpTags);
    }

    /**
     * 出演者の一覧からカンマ区切りの文字列を作成して返します。
     * @param array $casts
     * @return string
     */
    public function createCastStr($casts = []) {

        $tmpCast = [];

        foreach($casts as $cast) {
            $tmpCast[] = $cast['name'];
        }

        return implode(',', $tmpCast);
    }

}