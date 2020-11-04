<?php

namespace GenDiff\Formatters\Pretty;

function space($depth)
{
    $space = str_repeat(" ", $depth * 4);
    return "  $space";
}

function nodeToPretty($node, $depth)
{
    if (is_bool($node)) {
        return var_export($node, true);
    }

    if ($node === null) {
        return 'null';
    }

    if (!is_object($node)) {
        return $node;
    }
    $space = space($depth);
    $keys = array_keys(get_object_vars($node));
    $editNode = array_map(
        function ($key) use ($node, $space, $depth) {
            $name = $key;
            $oldValue = $node->$key;
            if (is_object($node)) {
                $depth += 1;
                $value = nodeToPretty($oldValue, $depth);
                return "$space      $name: $value";
            }
        },
        $keys
    );
        $result = implode("\n", $editNode);
        return "{\n{$result}\n$space  }";
}

function treeToPretty($astTree, $depth = 0)
{
  
    $space = space($depth);
    $diffList = array_map(function ($node) use ($space, $depth) {
        $oldValue = nodeToPretty($node['oldValue'], $depth);
        $newValue = nodeToPretty($node['newValue'], $depth);
        switch ($node['type']) {
            case 'added':
                return "$space+ {$node['name']}: $oldValue";
            case 'deleted':
                return "$space- {$node['name']}: $oldValue";
            case 'unchanged':
                return "$space  {$node['name']}: $oldValue";
            case 'changed':
                return "$space- {$node['name']}: $oldValue\n$space+ {$node['name']}: $newValue";
            case 'nested':
                $depth += 1;
                $children = treeToPretty($node['children'], $depth);
                return "$space  {$node['name']}: {\n$children\n$space  }";
            default:
                throw new \Exception("Unknown type {$node['type']}");
        }
    }, $astTree);
    return implode("\n", $diffList);
}

function renderPretty($astTree)
{
    $diffList = treeToPretty($astTree);
    return  "{\n{$diffList}\n}";
}
