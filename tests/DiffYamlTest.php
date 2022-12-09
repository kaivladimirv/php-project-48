<?php

declare(strict_types=1);

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DiffYamlTest extends TestCase
{
    protected string $pathToFile1;
    protected string $pathToFile2;

    protected function setUp(): void
    {
        $this->pathToFile1 = $this->getFixtureFullPath('file1.yaml');
        $this->pathToFile2 = $this->getFixtureFullPath('file2.yaml');
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
        $expected = file_get_contents($this->getFixtureFullPath('expected.txt'));

        $this->assertEquals($expected, genDiff($this->pathToFile1, $this->pathToFile2));
    }
}
