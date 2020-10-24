<?php

namespace GenDiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function parser($data, $extension)
{
    switch ($extension) {
        case 'json':
            return  json_decode($data, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($data);
        default:
            throw new \Exception("unknown type $extension");
    }
}
