<?php
require __DIR__ . '/vendor/autoload.php';

$DOM = new Drajathasan\Citationscraper\Dom;

echo '<pre>';
var_dump($DOM->getContent('https://scholar.google.com/citations?hl=id&user=3sVKkHkAAAAJ'));
echo '</pre>';
