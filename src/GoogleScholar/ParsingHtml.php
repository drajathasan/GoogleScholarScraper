<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-01-19 08:05:11
 * @modify date 2022-01-19 08:05:11
 * @license GPLv3
 * @desc [description]
 */

namespace Drajathasan\Citationscraper\GoogleScholar;

use Drajathasan\Citationscraper\Output;

trait ParsingHtml
{
    public function getDetail()
    {
        foreach ($this->Data as $Index => $Result) {
            // Load HTML
            $this->loadLocalContent($Result);

            // Setup data
            $Title = $this->query('//a[@class="gsc_a_at"]');
            $TitleInformation = $this->query('//div[@class="gs_gray"]');
            $NumberCitation = $this->query('//a[@class="gsc_a_ac gs_ibl"]');
            $PublishYear = $this->query('//span[@class="gsc_a_h gsc_a_hc gs_ibl"]');

            // We dont want to our data is null
            // then unset it
            if (is_null($Title))
            {
                unset($this->Data[$Index]);
                continue;
            }

            // Making mutation data to make it so detail and readable
            $this->Data[$Index] = [
                'title' => [
                    'link' => !is_null($Title) ? 'https://scholar.google.com/' . ltrim($Title[0]->getAttribute('href'), '/') : null,
                    'label' => !is_null($Title) ? $Title[0]->textContent : null
                ],
                'author' => !is_null($TitleInformation) ? $TitleInformation[0]->textContent : null,
                'journal' => !is_null($TitleInformation) ? $TitleInformation[1]->textContent : null,
                'citation' => [
                    'link' => !is_null($NumberCitation) ? $NumberCitation[0]->getAttribute('href') : null,
                    'number' => !is_null($NumberCitation) ? $NumberCitation[0]->textContent : null
                ],
                'publishyear' => !is_null($PublishYear) ? $PublishYear[0]->textContent : null
            ];
        }

        $this->Result['article'] = count($this->Data);
        $this->Result['data'] = $this->Data;

        return $this;
    }

    public function query(string $QuerySearch)
    {
        $getQuery = $this->getPath()->query($QuerySearch);

        return count($getQuery) > 0 ? $getQuery : null;
    }
}
