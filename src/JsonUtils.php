<?php

namespace Beequeue\Tweaky;

class JsonUtils
{
    /**
     * json_decode but strip comments beforehand
     *
     * @link http://php.net/manual/en/function.json-decode.php#112735
     */
    public static function cleanDecode(
        $json,
        $assoc = false,
        $depth = 512,
        $options = 0
    ) {
        // search and remove comments like /* */ and //
        $json = preg_replace(
            "#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#",
            '',
            $json
        );

        if (version_compare(phpversion(), '5.4.0', '>=')) {
            $json = json_decode($json, $assoc, $depth, $options);
        } elseif (version_compare(phpversion(), '5.3.0', '>=')) {
            $json = json_decode($json, $assoc, $depth);
        } else {
            $json = json_decode($json, $assoc);
        }

        return $json;
    }
}
