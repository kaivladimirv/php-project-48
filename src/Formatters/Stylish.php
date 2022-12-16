<?php

declare(strict_types=1);

namespace Differ\Formatters\Stylish;

function stylish(array $diff): string
{
    $make = function (array $diff, int $nestingLevel = 1, string $parentState = '') use (&$make) {
        return array_reduce(
            array_keys($diff),
            function (array $acc, mixed $key) use ($make, $diff, $nestingLevel, $parentState) {
                return array_reduce(
                    array_keys($diff[$key]),
                    function (array $items, string $state) use ($make, $diff, $key, $nestingLevel, $parentState) {
                        $value = $diff[$key][$state];

                        if (is_array($value)) {
                            $value = [...$make($value, $nestingLevel + 1, $state)];
                        }

                        return array_merge($items, [buildItem($parentState, $state, $key, $value, $nestingLevel)]);
                    },
                    $acc
                );
            },
            []
        );
    };

    return implode(PHP_EOL, [
        '{',
        ...$make($diff),
        '}',
    ]);
}

function buildItem(string $parentState, string $state, mixed $key, mixed $value, int $nestingLevel): string
{
    if ($parentState !== $state) {
        $indent = mergeIndentWithState(buildIndent($nestingLevel), $state);
    } else {
        $indent = buildIndent($nestingLevel);
    }

    $valueAsString = convertValueToString($value, $nestingLevel);

    return "$indent$key: " . $valueAsString;
}

function mergeIndentWithState(string $indent, string $state): string
{
    return substr_replace($indent, $state, -2, 1);
}

function convertValueToString(mixed $value, int $nestingLevel): string
{
    if (!is_array($value)) {
        return trim(var_export($value ?? 'null', true), "'");
    }

    return implode(PHP_EOL, [
        '{',
        ...$value,
        buildIndent($nestingLevel) . '}',
    ]);
}

function buildIndent(int $nestingLevel): string
{
    $indentLength = 4;

    return str_repeat(' ', $indentLength * $nestingLevel);
}
