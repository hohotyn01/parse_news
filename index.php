<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
require_once 'app/sql/Insert.php';
require_once 'app/services/Parser.php';

$page = file_get_contents(
    'https://korrespondent.net/ajax/module.aspx?spm_id=1055&type=-1&IsAjax=true'
);

$document = phpQuery::newDocument($page);

$dateElements = (
    pq($document)
        ->find('.time-articles')
        ->find('.time-articles__date')
);

$articles = Parser::getThemeDate($dateElements);

$response = insert::articles($articles);

echo('<pre>');
var_dump($articles);
echo('</pre>');

phpQuery::unloadDocuments();
