<?php

declare(strict_types=1);

namespace Differ\Differ;

use function Differ\ArraysDiffer\getDiffOfArrays;
use function Differ\Formatter\format;
use function Differ\Parsers\parseFile;

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $fileData1 = parseFile($pathToFile1);
    $fileData2 = parseFile($pathToFile2);

    $diff = getDiffOfArrays($fileData1, $fileData2);

    return format($diff, $format);
}
