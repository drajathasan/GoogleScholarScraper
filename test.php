<?php
@error_reporting(-1);
@ini_set('display_errors', true);


use Drajathasan\Citationscraper\GoogleScholar\Article;
use Drajathasan\Citationscraper\Output;

require __DIR__ . '/vendor/autoload.php';

$Article = Article::getInstance();
// $Article->debug();
$Article->setAdditionalError('mungkin gagal mengambil data dari scholar');

$Article
    ->setUrl('https://scholar.google.co.id/citations?user=P17nqLgAAAAJ&view_op=list_works&sortby=pubdate')
    ->getContent();


if (empty($Article->getError()))
{
    Output::debug($Article->getAllTitle()->getDetail()->getResult());
}
else
{
    echo $Article->getError();
}
