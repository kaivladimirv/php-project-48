<?php

declare(strict_types=1);

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;
use UnexpectedValueException;

function parseFile(string $pathToFile): array
{
    $fileExtension = pathinfo($pathToFile, PATHINFO_EXTENSION);

    return match ($fileExtension) {
        'json' => parseJsonFile($pathToFile),
        'yaml' => parseYamlFile($pathToFile),
        default => throw new UnexpectedValueException("Unsupported file type $fileExtension"),
    };
}

function parseJsonFile(string $pathToFile): array
{
    return json_decode(file_get_contents($pathToFile), true);
}

function parseYamlFile(string $pathToFile): array
{
    return (array) Yaml::parseFile($pathToFile, Yaml::PARSE_OBJECT_FOR_MAP);
}
