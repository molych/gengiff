<?php

namespace GenDiff\BuildAst;

use function Funct\Collection\union;
use function GenDiff\FunctionsTrees\createNode;

function buildAst($firstFile, $secondFile)
{

    $keys = union(array_keys($firstFile), array_keys($secondFile));
    sort($keys);
   
    $astTree = array_map(function ($key) use ($firstFile, $secondFile) {
        
        if (!isset($firstFile[$key])) {
            return createNode($key, 'added', $secondFile[$key], null, null);
        } elseif (!isset($secondFile[$key])) {
            return createNode($key, 'deleted', $firstFile[$key], null, null);
        } elseif (is_array($firstFile[$key]) && is_array($secondFile[$key])) {
            $children = buildAst($firstFile[$key], $secondFile[$key]);
            return createNode($key, 'nested', null, null, $children);
        } elseif ($firstFile[$key] === $secondFile[$key]) {
            return createNode($key, 'unchanged', $firstFile[$key], null, null);
        } else {
            return createNode($key, 'changed', $firstFile[$key], $secondFile[$key], null);
        }
    }, $keys);
    return $astTree;
}
