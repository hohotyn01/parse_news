<?php

class Insert
{
    /*array $articles*/
    public static function articles(array $articles) :string
    {
        require_once "Connect.php";

        $mysqli = connect::mysqli();

        if(is_string($mysqli)){
            return $mysqli;
        }

        $query = ("
            INSERT INTO articles
                (title, id_article, `time`, link, image)
            VALUES
            ");

        $count = count($articles);

        foreach ($articles as $article) {
            if($article === end( $articles )) {
                $query .= (
                    "(
                        '".$article['title']."',
                        '".$article['id']."',
                        '".$article['time']."',
                        '".$article['link']."',
                        '".$article['image']."'
                    )"
                );
            }

            if (--$count <= 0) {
                continue;
            }

            $query .= (
                "(
                    '".$article['title']."',
                    '".$article['id']."',
                    '".$article['time']."',
                    '".$article['link']."',
                    '".$article['image']."'
                ),"
            );
        }
        unset($article);

        if($mysqli->set_charset("utf8")){
            $mysqli->query($query);
            $mysqli->close();

            return 'Inserting Database is seccessful';
        }

        $mysqli->close($link);

        return 'Error not valid encoding';
    }
}
