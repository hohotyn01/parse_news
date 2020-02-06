<?php

class Parser
{
    public static function getThemeDate(object $dateElements) :array
    {
        $dates = self::parseDate($dateElements);

        if(!is_array($dates) || empty($dates)){
            return [];
        }

        foreach ($dates as $date => $articles) {
            foreach ($articles as $article) {
                $time_title_link [] = [
                    'time' => (
                        $date .
                        ' ' .
                        pq($article)->find('.article__time')->text()
                    ),
                    'title' => (
                        pq($article)->find('.article__title a')->text()
                    ),
                    'link' => (
                        pq($article)->find('.article__title a')->attr('href')
                    )
                ];
            }
            unset($article);
        }
        unset($date, $articles);

        return self::parseImage($time_title_link);
    }

    protected static function parseDate(object $dateElements) :array
    {
        /* TODO: get Ukraine Time Zone and set Ukraine's today date! */
        $today = date('Y-m-d');

        $dates = [
            $today => null
        ];

        reset($dates);

        foreach ($dateElements as $dateElement) {
            $dates[key($dates)] = pq($dateElement)->prevAll('.article');
            $dates[self::fromRussian($today)] = (
                pq($dateElement)->nextAll('.article')
            );

            next($dates);
        }
        unset($dateElement);

        return $dates;
    }

    protected static function parseImage(array $dataArticles) :array
    {
        foreach ($dataArticles as $article){

            // Parse again on the link for get image
            $image = self::image($article['link']);

            $linkPregResult = preg_match(
                '/https:\/\/korrespondent\.net\/\S+\/(\d+)-.+/i',
                $article['link'],
                $linkParseResult
            );

            if (!$linkPregResult) {
                continue;
            }

            $article += [
                'id' => $linkParseResult[1],
                'image' => $image
            ];

            $articles[] = $article;
        }

        return $articles;
    }

    protected static function image(string $link) :string
    {
        $page = file_get_contents($link);

        $document = phpQuery::newDocument($page);

        $get_text = pq($document)->find('.col__big');

        return pq($get_text)->find('img')->attr('src');
    }

    //string $russString
    public static function fromRussian(string $document) :string
    {
        return date('Y-m-d', /*!!!*/strtotime('yesterday'));
    }
}
