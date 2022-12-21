<?php

declare(strict_types=1);

namespace Differ\Formatters\Plain;

function plain(array $diff): string
{
    $make = function (array $diff, array $pathToKey = []) use (&$make) {
        return array_reduce(
            array_keys($diff),
            function (array $acc, mixed $key) use ($make, $diff, $pathToKey) {
                $currPathToKey = array_merge($pathToKey, [$key]);

                $state = array_key_first($diff[$key]);
                $value = current($diff[$key]);

                if ($state === '') {
                    return is_array($value) ? array_merge($acc, [...$make($value, $currPathToKey)]) : $acc;
                } elseif (count($diff[$key]) === 2) {
                    return array_merge($acc, [buildLine($currPathToKey, '', $diff[$key]['-'], $diff[$key]['+'])]);
                } else {
                    return array_merge($acc, [buildLine($currPathToKey, $state, $value, $value)]);
                }
            },
            []
        );
    };

    return implode(PHP_EOL, $make($diff));
}

function buildLine(array $pathToKey, string $state, mixed $oldValue, mixed $newValue): string
{
    $oldValueAsString = convertValueToString($oldValue);
    $newValueAsString = convertValueToString($newValue);

    $stateDescription = match ($state) {
        '+' => "added with value: $newValueAsString",
        '-' => "removed",
        '' => "updated. From $oldValueAsString to $newValueAsString",
        default => '',
    };

    return "Property '" . implode('.', $pathToKey) . "' was $stateDescription";
}

function convertValueToString(mixed $value): string
{
    return is_array($value) ? '[complex value]' : (is_null($value) ? 'null' : var_export($value, true));
}
