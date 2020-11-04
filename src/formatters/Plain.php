<?php

namespace GenDiff\Formatters\Plain;

use function Funct\Collection\compact;

function nodeToPlain($node)
{
    if (is_bool($node)) {
        return var_export($node, true);
    }

    if ($node === null) {
        return 'null';
    }
    
    return is_object($node) ? '[complex value]' : "'$node'";
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
                return "Property '$path' was added with value: $oldValue";
            case 'deleted':
                return "Property '$path' was removed";
            case 'changed':
                return "Property '$path' was updated. From $oldValue to $newValue";
            case 'nested':
                return renderPlain($node['children'], $path);
            case 'unchanged':
                return ;
            default:
                throw new \Exception("Unknown type {$node['type']}");
        }
    }, $tree);
    $diffList = compact($diffList);
    return  implode("\n", $diffList);
}
