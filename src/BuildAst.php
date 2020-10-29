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

function buildAst($firstContent, $secondContent)
{
    $keys = union(array_keys($firstContent), array_keys($secondContent));
    sort($keys);
    $astTree = array_map(function ($key) use ($firstContent, $secondContent) {
        if (!array_key_exists($key, $firstContent)) {
            return createNode($key, 'added', $secondContent[$key], null, null);
        } elseif (!array_key_exists($key, $secondContent)) {
            return createNode($key, 'deleted', $firstContent[$key], null, null);
        } elseif (is_array($firstContent[$key]) && is_array($secondContent[$key])) {
            $children = buildAst($firstContent[$key], $secondContent[$key]);
            return createNode($key, 'nested', null, null, $children);
        } elseif ($firstContent[$key] === $secondContent[$key]) {
            return createNode($key, 'unchanged', $firstContent[$key], null, null);
        } else {
            return createNode($key, 'changed', $firstContent[$key], $secondContent[$key], null);
        }
    }, $keys);
    return $astTree;
}
