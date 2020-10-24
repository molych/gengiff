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

function buildAst($parseredContentFileFirst, $parseredContentFileSecond)
{
    $keys = union(array_keys($parseredContentFileFirst), array_keys($parseredContentFileSecond));
    sort($keys);
    $astTree = array_map(function ($key) use ($parseredContentFileFirst, $parseredContentFileSecond) {
        if (!isset($parseredContentFileFirst[$key])) {
            return createNode($key, 'added', $parseredContentFileSecond[$key], null, null);
        } elseif (!isset($parseredContentFileSecond[$key])) {
            return createNode($key, 'deleted', $parseredContentFileFirst[$key], null, null);
        } elseif (is_array($parseredContentFileFirst[$key]) && is_array($parseredContentFileSecond[$key])) {
            $children = buildAst($parseredContentFileFirst[$key], $parseredContentFileSecond[$key]);
            return createNode($key, 'nested', null, null, $children);
        } elseif ($parseredContentFileFirst[$key] === $parseredContentFileSecond[$key]) {
            return createNode($key, 'unchanged', $parseredContentFileFirst[$key], null, null);
        } else {
            return createNode($key, 'changed', $parseredContentFileFirst[$key], $parseredContentFileSecond[$key], null);
        }
    }, $keys);
    return $astTree;
}
