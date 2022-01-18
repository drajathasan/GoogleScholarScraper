<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-01-18 16:46:32
 * @modify date 2022-01-18 16:46:32
 * @license GPLv3
 * @desc [description]
 */

namespace Drajathasan\Citationscraper\GoogleScholar;

use Drajathasan\Citationscraper\{Dom,Output};

class Article extends Dom
{
    private static $Instance = null;

    private function __construct()
    {
        parent::__construct();
    }

    public function getAllTitle()
    {
        $Statistic = $this->getSimpleStatistic(['citation','article']);
        $LoopRequest = ceil($Statistic['article'] / 10);

        // First record
        $Detail = $this->getPath()->query('//tr[@class="gsc_a_tr"]');

        // foreach ($Title as $title) {
        //     echo ($title->ownerDocument->saveHTML($title)) . '<br>';
        // }

        // $List = [];
        // foreach ($Detail as $index => $details) {
        //     $List[] = $details->ownerDocument->saveHTML($details);
        // }

        // echo '<pre>';
        // var_dump($List);
        // echo '</pre>';
        // exit;

        // for ($i=2; $i < $LoopRequest; $i++) { 
        //     # code...
        // }
        $response = $this->client->request('POST', $this->getUrl() . '&cstart=20&pagesize=80');

        var_dump($response->getBody()->getContents());
    }

    public function getSimpleStatistic(array $MapData = ['Citation', 'Number of Articles'])
    {
        $Query = $this->getPath()->query("//td[@class='gsc_rsb_std']");

        $Result = [];
        foreach ($Query??[] as $key => $value) {
            if (in_array($key, [0,1])) 
                $Result[$MapData[$key]] = strip_tags($value->ownerDocument->saveHTML($value));
        }

        return $Result;
    }

    public static function getInstance()
    {
        if (is_null(self::$Instance)) self::$Instance = new Article;

        return self::$Instance;
    }
}