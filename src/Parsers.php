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
        'yaml', 'yml' => parseYamlFile($pathToFile),
        default => throw new UnexpectedValueException("Unsupported file type $fileExtension"),
    };
}

function parseJsonFile(string $pathToFile): array
{
    $data = file_get_contents($pathToFile);
    if ($data === false) {
        return [];
    }

    return json_decode($data, true);
}

function parseYamlFile(string $pathToFile): array
{
    $data = Yaml::parseFile($pathToFile, Yaml::PARSE_OBJECT_FOR_MAP);

    return convertObjectToArray($data);
}

function convertObjectToArray(object $object): array
{
    return json_decode(json_encode($object), true);
}
