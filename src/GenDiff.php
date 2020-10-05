<?php

namespace GenDiff\GenDiff;

use function GenDiff\Parsers\parser;

function getAbsolutePath($filePath)
{
    if (file_exists(getcwd() . "/file")) {
        return getcwd() . "/$filePath";
    } else {
        return $filePath;
    }
}

function genDiff($filePath1, $filePath2)
{
    $filePath1 = getAbsolutePath($filePath1);
    $filePath2 = getAbsolutePath($filePath2);

    $extensionPrev = pathinfo($filePath1, PATHINFO_EXTENSION);
    $extensionNext = pathinfo($filePath2, PATHINFO_EXTENSION);

    $prev = file_get_contents($filePath1);
    $next = file_get_contents($filePath2);


    $prev = parser($prev, $extensionPrev);
    $next = parser($next, $extensionNext);

    $allJsonItems = array_merge($prev, $next);
    ksort($allJsonItems);

    $diffList = array_map(function ($key, $item) use ($prev, $next) {

        if (is_bool($item)) {
            $item =  var_export($item, true);
        }

        if (!isset($prev[$key])) {
            return "\t+ $key: $item";
        }
        
        if (!isset($next[$key])) {
            return "\t- $key: $item";
        }
        
        if ($item === $prev[$key]) {
            return "\t  $key: $item";
        }
        
        if ($item !== $prev[$key]) {
            return "\t+ $key: $item\n\t- $key: $prev[$key]";
        }
    }, array_keys($allJsonItems), $allJsonItems);

    $diffList = implode("\n", $diffList);
    $result = "{\n$diffList\n}\n";
    return $result;
}
