<?php

abstract class Date
{
    public static function takeDate($document)
    {
        // Parse date
        $parse = pq($document)->find('.time-articles__date');
        // Date for string and phpQuery
        $parse_date = pq($parse)->text();

        $date = self::dayMouth($parse_date);

        return [
            'date_yesterday' => (
                date("Y") .
                '-' .
                $date['month'] .
                '-' .
                $date['day'][0]
            ),
            'date_to_day' => (
                date("Y") .
                '-' .
                $date['month'] .
                '-' .
                ++$date['day'][0]
            )
        ];
    }

    protected static function dayMouth($parse_date)
    {
        $arr_months = [
            '01' => 'ЯНВАРЯ',
            '02' => 'ФЕВРАЛЯ',
            '03' => 'МАРТА',
            '04' => 'АПРЕЛЯ',
            '05' => 'МАЯ',
            '06' => 'ИЮНЯ',
            '07' => 'ИЮЛЯ',
            '08' => 'АВГУСТА',
            '09' => 'СЕНТЯБРЯ',
            '10' => 'ОКТЯБРЯ',
            '11' => 'НОЯБРЯ',
            '12' => 'ДЕКАБРЯ'
        ];

        $day_mouth = explode(' ', $parse_date);
        $month = array_search($day_mouth[1], $arr_months);

        return [
            'month' => $month,
            'day' => $day_mouth
        ];
    }
}
