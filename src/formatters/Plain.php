<?php

namespace GenDiff\Formatters\Plain;

use function Funct\Collection\compact;

function nodeToPlain($node)
{
    if (is_bool($node)) {
        return var_export($node, true);
    }
    return (is_array($node)) ? '[complex value]' : $node;
}


function renderPlain($tree, $pathRoot = null)
{

    $diffList = array_map(function ($node) use ($pathRoot) {
          
        $newValue = nodeToPlain($node['newValue']);
        $oldValue = nodeToPlain($node['oldValue']);
       

        if (isset($pathRoot)) {
            $pathParts[] = $pathRoot;
        }

        $pathParts[] = $node['name'];
        $path = implode('.', $pathParts);

            
        switch ($node['type']) {
            case 'added':
                return "Property '$path' was added with value: '$oldValue'";
            case 'deleted':
                return "Property '$path' was removed";
            case 'changed':
                return "Property '$path' was updated. From '$oldValue' to '$newValue'";
            case 'nested':
                return renderPlain($node['children'], $node['name']);
            case 'unchanged':
                return ;
            default:
                throw new \ErrorException("Unknown type {$node['type']}");
        }
    }, $tree);
    $diffListClear = compact($diffList);
    $result = implode("\n", $diffListClear);
    return $result;
}
