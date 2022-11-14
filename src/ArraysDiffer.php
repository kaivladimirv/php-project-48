<?php

declare(strict_types=1);

namespace Differ\ArraysDiffer;

function getDiffOfArrays(array $fileData1, array $fileData2): array
{
    $result = [];

    $keys1 = array_keys($fileData1);
    $keys2 = array_keys($fileData2);
    $allKeys = array_unique(array_merge($keys1, $keys2));
    sort($allKeys);

    foreach ($allKeys as $key) {
        $value1 = $fileData1[$key] ?? null;
        $value2 = $fileData2[$key] ?? null;
        $isAdded = !array_key_exists($key, $fileData1);
        $isDeleted = !array_key_exists($key, $fileData2);

        if ($isAdded) {
            $diff = ['+' => $value2];
        } elseif ($isDeleted) {
            $diff = ['-' => $value1];
        } elseif ($value1 === $value2) {
            $diff = [' ' => $value1];
        } else {
            $diff = [
                '-' => $value1,
                '+' => $value2,
            ];
        }

        $result[$key] = $diff;
    }

    return $result;
}
