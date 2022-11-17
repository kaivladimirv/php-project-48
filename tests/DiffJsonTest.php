<?php

declare(strict_types=1);

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DiffJsonTest extends TestCase
{
    protected string $pathToFile1;
    protected string $pathToFile2;

    protected function setUp(): void
    {
        $this->pathToFile1 = $this->getFixtureFullPath('fileFlat1.json');
        $this->pathToFile2 = $this->getFixtureFullPath('fileFlat2.json');
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

    public function testFlatJson(): void
    {
        $expected = file_get_contents($this->getFixtureFullPath('expected1.txt'));

        $this->assertEquals($expected, genDiff($this->pathToFile1, $this->pathToFile2));
    }
}
