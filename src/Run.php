<?php

namespace Gendiff\Run;

use Docopt;

const DOC = <<<DOC
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>
  
Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: stylish]
DOC;

function run()
{
    $args = Docopt::handle(DOC);

    return $args;
}
