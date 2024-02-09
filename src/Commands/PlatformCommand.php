<?php

namespace Envor\Platform\Commands;

use Illuminate\Console\Command;

class PlatformCommand extends Command
{
    public $signature = 'platform';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
