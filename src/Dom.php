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
use Exception;
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

    public function getContent(string $failedMessage = '')
    {
        $HttpRequest = $this->client->request('GET', $this->url);

        if ($HttpRequest->getStatusCode() != 200) 
            throw new \GuzzleHttp\Exception\ClientException('Error : ' . $HttpRequest->getStatusCode() . $failedMessage);

        @$this->doc->loadHTML($HttpRequest->getBody()->getContents());
        $this->path = new DOMXpath($this->doc);
        
        return $this;
    }

    public function loadLocalContent(string $Content)
    {
        @$this->doc->loadHTML($Content);
        $this->path = new DOMXpath($this->doc);
        
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getDoc()
    {
        return $this->doc;
    }

    public static function getInstance()
    {
        return new Dom;
    }
}