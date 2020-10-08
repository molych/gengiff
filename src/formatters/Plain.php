<?php

namespace GenDiff\Formatters\Plain;

use function GenDiff\FunctionsTrees\getName;
use function GenDiff\FunctionsTrees\getNodeType;
use function GenDiff\FunctionsTrees\getOldValue;
use function GenDiff\FunctionsTrees\getNewValue;
use function GenDiff\FunctionsTrees\getChildren;
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
          
        $name = getName($node);
        $oldValue = getOldValue($node);
        $newValue = getNewValue($node);
        $type = getNodeType($node);
        $children = getChildren($node);

        $newValue = nodeToPlain($newValue);
        $oldValue = nodeToPlain($oldValue);
       

        if (isset($pathRoot)) {
            $pathParts[] = $pathRoot;
        }

        $pathParts[] = $name;
        $path = implode('.', $pathParts);

            
        switch ($type) {
            case 'added':
                return "Property '$path' was added with value: '$oldValue'";
            case 'deleted':
                return "Property '$path' was removed";
            case 'changed':
                return "Property '$path' was updated. From '$oldValue' to '$newValue'";
            case 'nested':
                return renderPlain($children, $name);
            case 'unchanged':
                return ;
            default:
                throw new \ErrorException("Unknown type $type");
        }
    }, $tree);
    $diffListClear = compact($diffList);
    $result = implode("\n", $diffListClear);
    return $result;
}
