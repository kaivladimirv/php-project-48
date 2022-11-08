<?php

declare(strict_types=1);

namespace DifferenceCalculator\DocReader;

function readDoc(): string
{
    return <<<DOC
gendiff -h

Generate diff

Usage: 
    gendiff (-h|--help)
    gendiff (-v|--version)
    gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: stylish]  
DOC;
}