<?php

namespace GenDiff\Formatters\Pretty;

function space($deep)
{
    return str_repeat(" ", $deep * 4);
}

function toPretty($tree, $deep = 0)
{
    $diffList = array_map(function ($item) use ($deep) {
        $name = $item['name'];
        $oldValue = $item['oldValue'];
        $newValue = $item['newValue'];
        $space = space($deep);
        switch ($item['type']) {
            case 'added':
                return "$space\t+ $name:$oldValue";
            case 'deleted':
                return "$space\t- $name:$oldValue";
            case 'unchange':
                return "$space\t  $name:$oldValue";
            case 'change':
                return "$space\t+ $name:$newValue\n$space\t- $name:$oldValue";
            case 'nested':
                $newDeep = $deep + 1;
                $secondBrackets = $deep + 2;
                $space = space($newDeep);
                $secondBrackets = space($secondBrackets);
                $children = toPretty($item['children'], $newDeep);
                return "$space  $name:{\n$children\n$secondBrackets}";
        }
    }, $tree);
  
    $result = implode("\n", $diffList);
      return $result;
}
