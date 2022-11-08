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

Options:
  -h --help       Show this screen
  -v --version    Show version  
DOC;
}