<?php

namespace GenDiff\Formatters\Pretty;

function space(int $depth): string
{
    return str_repeat(" ", $depth * 4);
}

function nodeToPretty($node, $depth)
{
    if (is_bool($node)) {
        return var_export($node, true);
    }

    $space = space($depth);
    $currentSpace = "  $space";
    if (is_array($node)) {
        $keys = array_keys($node);
        $editNode = array_map(
            function ($key) use ($node, $currentSpace, $depth) {
                $name = $key;
                $oldValue = $node[$key];
              
                if (is_array($node)) {
                    (int) $depth += 1;
                    $value = nodeToPretty($oldValue, $depth);
                    return "$currentSpace     $name: $value$currentSpace";
                }
            },
            $keys
        );
        $result = implode("\n", $editNode);
        return "{\n{$result}\n$currentSpace  }";
    }
    return $node;
}


function treeToPretty($tree, int $depth = 0)
{

    $space = space($depth);
    $currentSpace = "  $space";
    $diffList = array_map(function ($node) use ($currentSpace, $depth) {

        $oldValue = nodeToPretty($node['oldValue'], $depth);
        $newValue = nodeToPretty($node['newValue'], $depth);
    
        switch ($node['type']) {
            case 'added':
                return "$currentSpace+ {$node['name']}: $oldValue";
            case 'deleted':
                return "$currentSpace- {$node['name']}: $oldValue";
            case 'unchanged':
                return "$currentSpace  {$node['name']}: $oldValue";
            case 'changed':
                return "$currentSpace+ {$node['name']}: $newValue\n$currentSpace- {$node['name']}: $oldValue";
            case 'nested':
                $depth += 1;
                $children = treeToPretty($node['children'], $depth);
                return "$currentSpace  {$node['name']}: {\n$children\n$currentSpace  }";
            default:
                throw new \Exception("unknown type {$node['type']}");
        }
    }, $tree);

    $result = implode("\n", $diffList);
    return $result;
}


function renderPretty($tree)
{
    $tree =  treeToPretty($tree);
    return  "{\n{$tree}\n}";
}
