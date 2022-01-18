<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-01-18 16:59:37
 * @modify date 2022-01-18 16:59:37
 * @license GPLv3
 * @desc [description]
 */

namespace Drajathasan\Citationscraper;

use DOMDocument;
use DOMXpath;
use GuzzleHttp\Client;

class Dom
{
    private $doc;
    private $path;
    private $client;

    public function __construct()
    {
        $this->doc = new DOMDocument;
        $this->client = new Client;
    }

    public function getContent(string $Url)
    {
        $this->dom->loadHTML( $this->client->request('GET', $Url)->getBody()->getContents() );
        $this->path = new DOMXpath($this->dom);
        
        return $this;
    }


}