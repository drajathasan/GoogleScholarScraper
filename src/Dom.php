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
    private $error = '';
    private $errorMessage = ' : failed';
    private $debug = false;

    protected function __construct()
    {
        $this->doc = new DOMDocument;
        $this->client = new Client;
    }

    public function debug()
    {
        $this->debug = true;
    }

    public function setUrl(string $Url)
    {
        $this->url = $Url;

        return $this;
    }

    public function setAdditionalError(string $Message)
    {
        $this->errorMessage = $Message;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getContent()
    {
        try {

            $HttpRequest = $this->client->request('GET', $this->url, ['http_errors' => $this->debug]);

            if ($HttpRequest->getStatusCode() == 200)
            {
                @$this->doc->loadHTML($HttpRequest->getBody()->getContents());
                $this->path = new DOMXpath($this->doc);
            }
            else
            {
                throw new Exception('Error ' . $HttpRequest->getStatusCode() . ' : ' . $this->errorMessage);
            }

        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
        
        return $this;
    }

    public function getError()
    {
        return $this->error;
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