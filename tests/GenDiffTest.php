<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\GenDiff\genDiff;

class GenDiffTest extends TestCase
{

    /**
     * @dataProvider additionProvider
     */
    public function testGenDiffJ($type, $format)
    {
    
        $file1 = __DIR__ . "/fixtures/$type/$format/file1.$type";
        $file2 = __DIR__ . "/fixtures/$type/$format/file2.$type";
        $expected = file_get_contents(__DIR__ . "/fixtures/$type/$format/example");
        $actual = genDiff($file1, $file2, $format);
        $this->assertEquals($expected, $actual);
    }

    public function additionProvider()
    {
        return [
            "json-pretty" => ['json', 'pretty'],
            "json-plain" => ['json', 'plain'],
            "json-json" => ['json', 'json'],
            "yaml-pretty" => ['yaml', 'pretty'],
            "yaml-plain" => ['yaml', 'plain'],
            "yaml-json" => ['yaml', 'json'],
            "yml-json" => ['yml', 'json'],
        ];
    }
}
