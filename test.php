<?php
@error_reporting(-1);
@ini_set('display_errors', true);


use Drajathasan\Citationscraper\GoogleScholar\Article;

require __DIR__ . '/vendor/autoload.php';

$Article = Article::getInstance();

$Article
    ->setUrl('https://scholar.google.co.id/citations?hl=id&user=3sVKkHkAAAAJ&view_op=list_works&sortby=pubdate')
    ->getContent();


var_dump($Article->getAllTitle());
