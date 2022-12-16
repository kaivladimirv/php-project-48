<?php

declare(strict_types=1);

namespace Differ\ArraysDiffer;

use function Functional\sort;

function getDiff(array $array1, array $array2): array
{
    $keys1 = array_keys($array1);
    $keys2 = array_keys($array2);
    $allKeys = array_unique(array_merge($keys1, $keys2));
    $allKeys = sort($allKeys, fn($key1, $key2) => $key1 <=> $key2);

    return array_reduce(
        $allKeys,
        function (array $acc, mixed $key) use ($array1, $array2) {
            return array_merge($acc, [$key => buildDiff($key, $array1, $array2)]);
        },
        []
    );
}

function buildDiff(mixed $key, array $array1, array $array2): array
{
    $isAdded = !array_key_exists($key, $array1);
    $isDeleted = !array_key_exists($key, $array2);
    $value1 = $array1[$key] ?? null;
    $value2 = $array2[$key] ?? null;

    if ($isAdded) {
        $diff = ['+' => is_array($value2) ? getDiff([], $value2) : $value2];
    } elseif ($isDeleted) {
        $diff = ['-' => is_array($value1) ? getDiff($value1, []) : $value1];
    } elseif ((is_array($value1) and is_array($value2))) {
        $diff = ['' => getDiff($value1, $value2)];
    } elseif ($value1 !== $value2) {
        $diff = [
            '-' => is_array($value1) ? getDiff($value1, []) : $value1,
            '+' => is_array($value2) ? getDiff([], $value2) : $value2,
        ];
    } else {
        $diff = ['' => $value1];
    }

    return $diff;
}
