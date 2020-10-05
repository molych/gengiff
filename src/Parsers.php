<?php

namespace GenDiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function parser($data, $extension)
{

    switch ($extension) {
        case 'json':
            $data = json_decode($data, true);
            return $data;
        case 'yaml':
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new \Exception("unknown type $extension");
    }
}
