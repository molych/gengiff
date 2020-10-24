<?php

namespace GenDiff\GenDiff;

use function GenDiff\Parsers\parser;
use function GenDiff\BuildAst\buildAst;
use function Gendiff\Formatter\formatter;

function getData($path)
{
    if (!file_exists($path)) {
        throw new \Exception("$path does not exist");
    }
    $content = file_get_contents($path);
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    return [$extension, $content];
}

function genDiff($pathFileFirst, $pathFileSecond, $format = 'pretty')
{
    [$extensionFileFirst, $contentFileFirst] = getData($pathFileFirst);
    [$extensionFileSecond, $contentFileSecond] = getData($pathFileSecond);
    $parseredContentFileFirst = parser($contentFileFirst, $extensionFileFirst);
    $parseredContentFileSecond = parser($contentFileSecond, $extensionFileSecond);
    $astTree = buildAst($parseredContentFileFirst, $parseredContentFileSecond);
    $diffList = formatter($format, $astTree);
    return $diffList;
}
