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
    protected $client;
    private $url;

    protected function __construct()
    {
        $this->doc = new DOMDocument;
        $this->client = new Client;
    }

    public function setUrl(string $Url)
    {
        $this->url = $Url;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getContent()
    {
        @$this->doc->loadHTML($this->client->request('GET', $this->url)->getBody()->getContents());
        $this->path = new DOMXpath($this->doc);
        
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }
}