<?php

namespace Envor\Platform\Concerns;

trait ArrayableEnum
{
    /**
     * @return array <string, mixed>
     */
    public static function toArray(): array
    {
        return array_column(static::cases(), 'value', 'name');
    }
}
