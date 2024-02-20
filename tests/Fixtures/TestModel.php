<?php

namespace Envor\Platform\Tests\Fixtures;

use Envor\Platform\Concerns\HasLandingPage;
use Envor\Platform\Concerns\HasProfilePhoto;

class TestModel extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = [];

    use HasLandingPage;
    use HasProfilePhoto;
}
