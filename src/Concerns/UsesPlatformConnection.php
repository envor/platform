<?php

namespace Envor\Platform\Concerns;

trait UsesPlatformConnection
{
    public function getConnectionName(): string
    {
        return config('database.platform');
    }
}
