<?php

namespace GenDiff\GenDiff;

use function GenDiff\Parsers\parser;
use function GenDiff\BuildAst\buildAst;
use function Gendiff\Formatter\formatter;

function getData($file)
{
    if (!file_exists($file)) {
        throw new \Exception("$file does not exist");
    }

    $content = file_get_contents($file);
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    
    return [$extension, $content];
}

function genDiff($filePath1, $filePath2, $format = 'pretty')
{
   
    [$extensionFileFirst, $contentFileFirst] = getData($filePath1);
    [$extensionFileSecond, $contentFileSecond] = getData($filePath2);

    $before = parser($contentFileFirst, $extensionFileFirst);
    $after = parser($contentFileSecond, $extensionFileSecond);

    $astTree = buildAst($before, $after);
    
    $diffList = formatter($format, $astTree);

    return $diffList;
}
