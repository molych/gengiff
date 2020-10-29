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
    [$firstFilesExtention, $firstFilesContent] = getData($firstFilesPath);
    [$secondFilesExtention, $secondFilesContent] = getData($secondFilesPath);
    $parsedFirstFilesContent = parser($firstFilesContent, $firstFilesExtention);
    $parsedSecondFileContent = parser($secondFilesContent, $secondFilesExtention);
    $astTree = buildAst($parsedFirstFilesContent, $parsedSecondFileContent);
    $diffList = format($format, $astTree);
    return $diffList;
}
