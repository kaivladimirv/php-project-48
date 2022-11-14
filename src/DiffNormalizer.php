<?php

declare(strict_types=1);

namespace Differ\DiffNormalizer;

function normalizeToStylish(array $diff): string
{
    $result = array_reduce(
        array_keys($diff),
        function (array $acc, mixed $key) use ($diff) {
            $items = array_map(
                fn(string $state) => buildItem($state, $key, $diff[$key][$state]),
                array_keys($diff[$key])
            );

            return array_merge($acc, $items);
        },
        ['{']
    );

    $result[] = '}';

    return implode(PHP_EOL, $result);
}

function buildItem(string $state, mixed $key, mixed $value): string
{
    $indent = ' ';

    return "$indent $state $key: " . trim(var_export($value, true), "'");
}