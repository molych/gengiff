<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\GenDiff\genDiff;

class TestGenDiff extends TestCase
{
    public function testGenDiff()
    {
    
        $file1 = __DIR__ . '/fixtures/file1.json';
        $file2 = __DIR__ . '/fixtures/file2.json';
        $expected = file_get_contents(__DIR__ . '/fixtures/sample');
        $actual = genDiff($file1, $file2);
        $this->assertEquals($expected, $actual);
    }
}
