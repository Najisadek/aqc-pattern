<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumHelpers;

enum ProductStatus: string
{
    use EnumHelpers;

    case Active = 'active';
    case Discontinued = 'discontinued';
    case Draft = 'draft';
}
