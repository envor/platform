<?php

namespace Envor\Platform\Models;

use Envor\Platform\Concerns\HasPlatformUuids;
use Envor\Platform\Concerns\UsesPlatformConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LandingPage extends Model
{
    use HasFactory;
    use UsesPlatformConnection;
    use HasPlatformUuids;

    protected $guarded = [];

    public function model() : MorphTo
    {
        return $this->morphTo();
    }
}