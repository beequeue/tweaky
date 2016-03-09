<?php

namespace Beequeue\Tweaky;

/**
 * JSON Utils
 */
class JsonUtils
{
    /**
     * json_decode but strip comments (C-Style and //) beforehand
     *
     * @link http://php.net/manual/en/function.json-decode.php#112735
     * @param string $json The JSON string to parse
     * @param bool $assoc Whether to return associative arrays
     * @param int $depth User-sepcified recusion depth
     * @param int $options Bitmask as per json_decode
     * @return mixed As per json_decode
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

        $json = json_decode($json, $assoc, $depth, $options);

        return $json;
    }
}
