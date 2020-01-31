<?php

abstract class Result
{
    public static function takeResult($text, $date)
    {
        $result = [];

        foreach ($text as $div){
            $link = pq($div)->find('a')->attr('href');
            $title = pq($div)->find('a')->html();
            $time = pq($div)->find('.article__time')->html();

            // Parse again on the link for get image
            $image = self::image($link);

            $linkPregResult = preg_match(
                '/https:\/\/korrespondent\.net\/\S+\/(\d+)-.+/i',
                $link,
                $linkParseResult
            );

            if (!$linkPregResult) {
                continue;
            }

            $result[] = [
                'link' => $link,
                'title' => $title,
                'id' => $linkParseResult[1],
                'date' => $date . ' ' . $time,
                'image' => $image
            ];
        }

        return $result;
    }

    protected static function image(string $link)
    {
        $page = file_get_contents($link);

        $document = phpQuery::newDocument($page);

        $get_text = pq($document)->find('.col__big');

        return pq($get_text)->find('img')->attr('src');
    }
}
