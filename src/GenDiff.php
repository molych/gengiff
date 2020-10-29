<?php

namespace GenDiff\GenDiff;

use function GenDiff\Parsers\parser;
use function GenDiff\BuildAst\buildAst;
use function Gendiff\Formatter\format;

function getData($path)
{
    if (!file_exists($path)) {
        throw new \Exception("$path does not exist");
    }
    $content = file_get_contents($path);
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    return [$extension, $content];
}

function genDiff($firstFilesPath, $secondFilesPath, $format = 'pretty')
{
    [$firstFileExtention, $firstFileData] = getData($firstFilesPath);
    [$secondFileExtention, $secondFileData] = getData($secondFilesPath);
    $firstData = parser($firstFileData, $firstFileExtention);
    $secondData = parser($secondFileData, $secondFileExtention);
    $astTree = buildAst($firstData, $secondData);
    $diffList = format($format, $astTree);
    return $diffList;
}
