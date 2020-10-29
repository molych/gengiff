<?php

namespace GenDiff\BuildAst;

use function Funct\Collection\union;

function createNode($name, $type, $oldValue, $newValue, $children)
{
    return [
        'name' => $name,
        'type' => $type,
        'oldValue' => $oldValue,
        'newValue' => $newValue,
        'children' => $children
    ];
}

function buildAst($firstData, $secondData)
{
    $keys = union(array_keys($firstData), array_keys($secondData));
    sort($keys);
    $astTree = array_map(function ($key) use ($firstData, $secondData) {
        if (!array_key_exists($key, $firstData)) {
            return createNode($key, 'added', $secondData[$key], null, null);
        } elseif (!array_key_exists($key, $secondData)) {
            return createNode($key, 'deleted', $firstData[$key], null, null);
        } elseif (is_array($firstData[$key]) && is_array($secondData[$key])) {
            $children = buildAst($firstData[$key], $secondData[$key]);
            return createNode($key, 'nested', null, null, $children);
        } elseif ($firstData[$key] === $secondData[$key]) {
            return createNode($key, 'unchanged', $firstData[$key], null, null);
        } else {
            return createNode($key, 'changed', $firstData[$key], $secondData[$key], null);
        }
    }, $keys);
    return $astTree;
}
