<?php

namespace GenDiff\GenDiff;

use function GenDiff\Parsers\parser;
use function GenDiff\BuildAst\buildAst;
use function GenDiff\Formatters\Pretty\renderPretty;
use function GenDiff\Formatters\Plain\renderPlain;

function getAbsolutePath($filePath)
{
    if (file_exists(getcwd() . "/file")) {
        return getcwd() . "/$filePath";
    } else {
        return $filePath;
    }
}

function genDiff($filePath1, $filePath2, $format = 'pretty')
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

    switch ($format) {
        case 'pretty':
            return $astTree = renderPretty($astTree);
        case 'plain':
            return $astTree = renderPlain($astTree);
        default:
            throw new \ErrorException("Unknown fotmat $format");
    }
}
