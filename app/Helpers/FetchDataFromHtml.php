<?php
namespace App\Helpers;

class FetchDataFromHtml
{
    /** @var array  */
    protected static $keys = [
        'queue', 'building', 'schedule', 'floor', 'rooms', 'interior', 'state', 'square', 'price'
    ];

    /**
     * @return array
     */
    public static function handle($html)
    {
        $model = [];
        foreach(str_get_html($html)->find('.__qpage dd') as $i => $value) {
            $model[self::$keys[$i]] = trim($value->plaintext);
        }
        return $model;

    }
}