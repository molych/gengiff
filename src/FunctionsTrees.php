<?php

namespace Gendiff\FunctionsTrees;

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

function getName($node)
{
    return $node['name'];
}

function getOldValue($node)
{
    return $node['oldValue'];
}

function getNewValue($node)
{
    return $node['newValue'];
}

function getNodeType($node)
{
    return $node['type'];
}

function getChildren($node)
{
    return $node['children'];
}

