<?php

declare(strict_types=1);

namespace Differ\Differ;

use UnexpectedValueException;

use function Differ\ArraysDiffer\getDiff;
use function Differ\Stylish\stylish;
use function Differ\Parsers\parseFile;

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $fileData1 = parseFile($pathToFile1);
    $fileData2 = parseFile($pathToFile2);

    $diff = getDiff($fileData1, $fileData2);

    return format($diff, $format);
}

function format(array $diff, string $format): string
{
    return match ($format) {
        'stylish' => stylish($diff),
        default => throw new UnexpectedValueException("Unknown format $format")
    };
}
