<?php

namespace GenDiff\BuildAst;

use function Funct\Collection\union;
use function GenDiff\FunctionsTrees\createNode;


function buildAst($before, $after)
{

    $keys = union(array_keys($before), array_keys($after));
    sort($keys);
   
    $astTree = array_map(function ($key) use ($before, $after) {
        
        if (isset($before[$key])) {
            is_bool($before[$key]) ? var_export($before[$key], true) : $before[$key];
        }
        if (isset($afetr[$key])) {
            is_bool($after[$key]) ? var_export($after[$key], true) : $after[$key];
        }
        if (!isset($before[$key])) {
            return createNode($key, 'added', $after[$key], null, null);
        } elseif (!isset($after[$key])) {
            return createNode($key, 'deleted', $before[$key], null, null);
        } elseif (is_array($before[$key]) && is_array($after[$key])) {
            $children = buildAst($before[$key], $after[$key]);
            return createNode($key, 'nested', null, null, $children);
        } elseif ($before[$key] === $after[$key]) {
            return createNode($key, 'unchange', $before[$key], null, null);
        } else {
            return createNode($key, 'change', $before[$key], $after[$key], null);
        }
    }, $keys);
    return $astTree;
}
