<?php

declare(strict_types=1);

namespace DifferenceCalculator\App;

use Docopt;
use function DifferenceCalculator\DocReader\readDoc;

function run(): void
{
    $doc = readDoc();

    Docopt::handle($doc);
}