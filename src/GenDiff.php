<?php

namespace GenDiff\GenDiff;

use function GenDiff\Parsers\parser;
use function GenDiff\BuildAst\buildAst;
use function GenDiff\Formatters\Pretty\treeToPretty;

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

    $before = file_get_contents($filePath1);
    $after = file_get_contents($filePath2);

    $before = parser($before, $extensionPrev);
    $after = parser($after, $extensionNext);

    $astTree = buildAst($before, $after);
    $astTree = treeToPretty($astTree);


    return $astTree;
}
