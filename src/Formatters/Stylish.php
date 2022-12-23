<?php

declare(strict_types=1);

namespace Differ\Formatters\Stylish;

function stylish(array $diff): string
{
    $make = function (array $diff, int $nestingLevel = 1, string $parentState = '') use (&$make) {
        return array_reduce(
            array_keys($diff),
            function (array $acc, mixed $key) use ($make, $diff, $nestingLevel, $parentState) {
                $states = resetStateIfMatchesParent(extractStatesFromDiff($diff[$key]), $parentState);
                $values = extractValuesFromDiff(
                    $diff[$key],
                    fn($state, $value) => $make($value, $nestingLevel + 1, $state)
                );

                return array_merge($acc, buildItems($key, $states, $values, $nestingLevel));
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

function resetStateIfMatchesParent(array $states, string $parentState): array
{
    return array_reduce(
        $states,
        fn(array $newStates, string $state) => array_merge($newStates, [$parentState === $state ? '' : $state]),
        []
    );
}

function extractStatesFromDiff(array $diff): array
{
    return array_keys($diff);
}

function extractValuesFromDiff(array $diff, callable $arrayExtractor): array
{
    return array_reduce(
        array_keys($diff),
        function (array $values, string $state) use ($arrayExtractor, $diff) {
            $value = is_array($diff[$state]) ? $arrayExtractor($state, $diff[$state]) : $diff[$state];

            return array_merge($values, [$value]);
        },
        []
    );
}

function buildItems(mixed $key, array $states, array $values, int $nestingLevel): array
{
    return array_reduce(
        array_keys($values),
        function (array $items, mixed $index) use ($key, $states, $values, $nestingLevel) {
            return array_merge($items, [buildItem($states[$index], $key, $values[$index], $nestingLevel)]);
        },
        []
    );
}

function buildItem(string $state, mixed $key, mixed $value, int $nestingLevel): string
{
    if ($state !== '') {
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
