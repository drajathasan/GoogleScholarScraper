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
    private array $Result = [];
    private array $Data = [];

    use ParsingHtml;

    private function __construct()
    {
        parent::__construct();
    }

    public function getAllTitle()
    {
        $this->getSimpleStatistic(['citation','article']);
        $LoopRequest = ceil($this->Result['article'] / 10);

        // First record
        $Detail = $this->getPath()->query('//tr[@class="gsc_a_tr"]');

        foreach ($Detail as $index => $details) {
            $this->Data[] = $details->ownerDocument->saveHTML($details);
        }

        $OriginUrl = $this->getUrl();
        for ($i=2; $i < $LoopRequest; $i++) { 
            $this
                ->setUrl($OriginUrl . '&cstart=' . ($i * 10) . '&pagesize=80')
                ->getContent();

            $NextPage = $this->getPath()->query('//tr[@class="gsc_a_tr"]');

            foreach ($NextPage as $index => $details) {
                $this->Data[] = $details->ownerDocument->saveHTML($details);
            }
        }

        return $this;
    }

    public function getSimpleStatistic(array $MapData = ['Citation', 'Number of Articles'])
    {
        $Query = $this->getPath()->query("//td[@class='gsc_rsb_std']");

        foreach ($Query??[] as $key => $value) {
            if (in_array($key, [0,1])) 
                $this->Result[$MapData[$key]] = strip_tags($value->ownerDocument->saveHTML($value));
        }

        return $this;
    }

    public function genUrlCitationByYear(string $Url, int $StartYear, int $EndYear = 0)
    {
        $StartYear = '&as_ylo=' . $StartYear;
        $EndYear = $EndYear === 0 ? '' : '&as_yhi=' . $EndYear;

        return $Url . $StartYear . $EndYear;
    }

    public function getResult()
    {
        return $this->Result;
    }

    public static function getInstance()
    {
        if (is_null(self::$Instance)) self::$Instance = new Article;

        return self::$Instance;
    }
}