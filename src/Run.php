<?php

namespace GenDiff\Run;

use Docopt;

use function Gendiff\GenDiff\genDiff;

const DOC = <<<DOC
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>
  
Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: pretty]
DOC;

function run()
{
    $args = Docopt::handle(DOC);
    $format = $args->args['--format'];
    $genDiffList = genDiff($args['<firstFile>'], $args['<secondFile>'], $format);
    print_r("$genDiffList\n");
}
