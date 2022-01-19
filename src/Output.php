<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-01-18 23:15:20
 * @modify date 2022-01-18 23:15:20
 * @license GPLv3
 * @desc [description]
 */

namespace Drajathasan\Citationscraper;

class Output
{
    public static function json($Data)
    {
        ob_start();
        echo json_encode($Data);
        $Output = ob_get_clean();

        header('Content-Type: application/json');
        echo $Output;
        exit;
    }

    public static function debug($Content)
    {
        echo '<pre>';
        var_dump($Content);
        echo '</pre>';
    }
}