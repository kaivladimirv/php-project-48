<?php

declare(strict_types=1);

namespace Differ\Differ;

use function Differ\ArraysDiffer\getDiffOfArrays;
use function Differ\DiffNormalizer\normalizeToStylish;

function genDiff(string $pathToFile1, string $pathToFile2): string
{
    $fileData1 = readFile($pathToFile1);
    $fileData2 = readFile($pathToFile2);

    $diff = getDiffOfArrays($fileData1, $fileData2);

    return normalizeToStylish($diff);
}

function readFile(string $pathToFile): array
{
    return json_decode(file_get_contents($pathToFile), true);
}
