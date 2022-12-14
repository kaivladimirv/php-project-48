<?php

declare(strict_types=1);

namespace Differ\Formatters;

use UnexpectedValueException;

use function Differ\Formatters\Stylish\plain;
use function Differ\Formatters\Stylish\stylish;

function format(array $diff, string $format): string
{
    return match ($format) {
        'stylish' => stylish($diff),
        'plain' => plain($diff),
        default => throw new UnexpectedValueException("Unknown format $format")
    };
}
