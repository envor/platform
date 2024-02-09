<?php

namespace Envor\Platform\Concerns;

trait UsesPlatformConnection
{
    public function getConnectionName(): string
    {
        return config('platform.platform_database_connection');
    }
}
