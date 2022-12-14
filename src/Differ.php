<?php

declare(strict_types=1);

namespace Differ\Differ;

use function Differ\ArraysDiffer\getDiff;
use function Differ\Formatters\format;
use function Differ\Parsers\parseFile;

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $fileData1 = parseFile($pathToFile1);
    $fileData2 = parseFile($pathToFile2);

    $diff = getDiff($fileData1, $fileData2);

    return format($diff, $format);
}
