<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
require_once 'app/sql/connect.php';
require_once 'app/services/Date.php';
require_once 'app/services/Result.php';






$page = file_get_contents('https://korrespondent.net/ajax/module.aspx?spm_id=1055&type=-1&IsAjax=true');

$document = phpQuery::newDocument($page);

$date = Date::takeDate($document);

$next = pq($document)->find('.time-articles .time-articles__date')->nextAll();
$prev = pq($document)->find('.time-articles .time-articles__date')->prevAll();

$result_to_day = Result::takeResult($prev, $date['date_to_day']);
$result_yesterday = Result::takeResult($next, $date['date_yesterday']);

echo('<pre>');
var_dump($result_to_day);
echo "<hr>";
var_dump($result_yesterday);
echo('</pre>');die();


phpQuery::unloadDocuments();
