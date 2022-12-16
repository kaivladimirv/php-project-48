<?php

declare(strict_types=1);

namespace Differ\Formatters\Plain;

function plain(array $diff): string
{
    $make = function (array $diff, array $pathToKey = []) use (&$make) {
        return array_reduce(
            array_keys($diff),
            function (array $acc, mixed $key) use ($make, $diff, $pathToKey) {
                $pathToKey[] = $key;

                if (count($diff[$key]) === 2) {
                    return array_merge($acc, [buildLine($pathToKey, '', $diff[$key]['-'], $diff[$key]['+'])]);
                }

                return array_reduce(
                    array_keys($diff[$key]),
                    function (array $lines, string $state) use ($make, $diff, $key, $pathToKey) {
                        $value = $diff[$key][$state];

                        if ($state === '') {
                            return is_array($value) ? array_merge($lines, [...$make($value, $pathToKey)]) : $lines;
                        } else {
                            return array_merge($lines, [buildLine($pathToKey, $state, $value, $value)]);
                        }
                    },
                    $acc
                );
            },
            []
        );
    };

    return implode(PHP_EOL, $make($diff));
}

function buildLine(array $pathToKey, string $state, mixed $oldValue, mixed $newValue): string
{
    $oldValue = convertValueToString($oldValue);
    $newValue = convertValueToString($newValue);

    $stateDescription = match ($state) {
        '+' => "added with value: $newValue",
        '-' => "removed",
        '' => "updated. From $oldValue to $newValue",
        default => '',
    };

    return "Property '" . implode('.', $pathToKey) . "' was $stateDescription";
}

function convertValueToString(mixed $value): string
{
    return is_array($value) ? '[complex value]' : (is_null($value) ? 'null' : var_export($value, true));
}
