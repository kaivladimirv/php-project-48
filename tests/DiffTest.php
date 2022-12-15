<?php

declare(strict_types=1);

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DiffTest extends TestCase
{
    protected string $pathToJsonFile1;
    protected string $pathToJsonFile2;
    protected string $pathToYamlFile1;
    protected string $pathToYamlFile2;

    protected function setUp(): void
    {
        $this->pathToJsonFile1 = $this->getFixtureFullPath('file1.json');
        $this->pathToJsonFile2 = $this->getFixtureFullPath('file2.json');
        $this->pathToYamlFile1 = $this->getFixtureFullPath('file1.yaml');
        $this->pathToYamlFile2 = $this->getFixtureFullPath('file2.yaml');
    }

    private function getFixtureFullPath($fixtureName): string
    {
        $parts = [
            __DIR__,
            'fixtures',
            $fixtureName,
        ];

        return implode('/', $parts);
    }

    public function testStylishDiff(): void
    {
        $expected = file_get_contents($this->getFixtureFullPath('stylishExpected.txt'));

        $this->assertEquals($expected, genDiff($this->pathToJsonFile1, $this->pathToJsonFile2));
        $this->assertEquals($expected, genDiff($this->pathToYamlFile1, $this->pathToYamlFile2));
    }

    public function testPlainDiff(): void
    {
        $expected = file_get_contents($this->getFixtureFullPath('plainExpected.txt'));

        $this->assertEquals($expected, genDiff($this->pathToJsonFile1, $this->pathToJsonFile2, 'plain'));
        $this->assertEquals($expected, genDiff($this->pathToYamlFile1, $this->pathToYamlFile2, 'plain'));
    }

    public function testJsonDiff(): void
    {
        $expected = file_get_contents($this->getFixtureFullPath('jsonExpected.txt'));

        $this->assertJsonStringEqualsJsonString(
            $expected,
            genDiff($this->pathToJsonFile1, $this->pathToJsonFile2, 'json')
        );
        $this->assertJsonStringEqualsJsonString(
            $expected,
            genDiff($this->pathToYamlFile1, $this->pathToYamlFile2, 'json')
        );
    }
}
