<?php

namespace GenDiff\BuildAst;

use function Funct\Collection\union;
use function Funct\Collection\sortBy;

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
    $keys = union(array_keys(get_object_vars($firstData)), array_keys(get_object_vars($secondData)));
    $sortedKeys = sortBy($keys, function ($key) {
        return $key;
    });
    $astTree = array_map(function ($key) use ($firstData, $secondData) {
        if (!property_exists($firstData, $key)) {
            return createNode($key, 'added', $secondData->$key, null, null);
        } elseif (!property_exists($secondData, $key)) {
            return createNode($key, 'deleted', $firstData->$key, null, null);
        } elseif (is_object($firstData->$key) && is_object($secondData->$key)) {
            $children = buildAst($firstData->$key, $secondData->$key);
            return createNode($key, 'nested', null, null, $children);
        } elseif ($firstData->$key === $secondData->$key) {
            return createNode($key, 'unchanged', $firstData->$key, null, null);
        } else {
            return createNode($key, 'changed', $firstData->$key, $secondData->$key, null);
        }
    }, $sortedKeys);
    return $astTree;
}
