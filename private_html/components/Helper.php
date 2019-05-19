<?php

namespace app\components;

class Helper
{
    /**
     * convert persian special letters to arabic letters
     *
     * @param $value string
     * @return string
     */
    public static function persian2Arabic($value)
    {
        $patterns = array('/([.\\+*?\[^\]$(){}=!<>|:-])/', '/ی|ي|ئ/', '/ک|ك/', '/ه|ة/', '/ا|آ|إ|أ/', '/\s/');
        $replacements = array('', '[ی|ي|ئ]', '[ک|ك]', '[ه|ة]', '[اآإأ]', ' ');
        return preg_replace($patterns, $replacements, $value);
    }

    /**
     * convert jalali date to timestamp
     * @param string $date
     * @param string $delimiter
     * @return string
     */
    public static function jDateTotoGregorian($date, $delimiter = '/')
    {
        $date = self::convertNumbersToEnglish($date);
        if (($gtime = strtotime($date)) > 0)
            return $gtime;

        list($y, $m, $d) = explode($delimiter, $date);
        $date = \jDateTime::toGregorian($y, $m, $d);
        return strtotime("{$date[0]}/{$date[1]}/{$date[2]}");
    }

    /**
     * parse doctor status for clinic program.
     *
     * @param string $status
     * @return string
     */
    public static function parseDoctorStatus($status)
    {
        // f = Fellowship
        $fellowshipLabel = \Yii::t('words', 'Fellowship');
        // * = Absenteeism
        $absenteeismLabel = \Yii::t('words', 'Absenteeism');
        // - = Alternative
        $alternativeLabel = \Yii::t('words', 'Alternative');

        if (strpos($status, '*') !== false)
            return "<span class='btn btn-danger text-white'>$absenteeismLabel</span>";

        if (strpos($status, '-') !== false)
            return "<span class='btn btn-info text-white'>$alternativeLabel</span>";

        return '';
    }

    /**
     * Returns time str converted to time format
     *
     * @param string $str
     * @return string
     */
    public static function strToTime($str)
    {
        $len = strlen($str);
//        if ($len < 4) {
//            $str = $len <= 2? "{$str}00" : $str;
//            $str = strlen($str) == 5 ? "$str:00" : $str;
//        } else
            if ($len > 4)
            $str = substr($str, 0, 4);
        $th = strlen($str) === 3 ? substr($str, 0, 1) : substr($str, 0, 2);
        $tm = strlen($str) === 3 ? substr($str, 1) : substr($str, 2);
        return "$th:$tm";
    }

    public static function convertNumbersToPersian($matches)
    {
        $farsi_array   = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        return str_replace($english_array, $farsi_array, $matches);
    }

    public static function convertNumbersToEnglish($matches)
    {
        $farsi_array   = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        return str_replace($farsi_array, $english_array, $matches);
    }
}