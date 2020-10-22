<?php

namespace Gendiff\Formatter;

use function GenDiff\Formatters\Pretty\renderPretty;
use function GenDiff\Formatters\Plain\renderPlain;
use function GenDiff\Formatters\Json\renderJson;

function formatter($format, $astTree)
{
    switch ($format) {
        case 'pretty':
            return $astTree = renderPretty($astTree);
        case 'plain':
            return $astTree = renderPlain($astTree);
        case 'json':
            return $astTree = renderJson($astTree);
        default:
            throw new \ErrorException("Unknown fotmat $format");
    }
}
