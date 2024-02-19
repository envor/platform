<?php

namespace Envor\Platform\Tests\Fixtures;

use Envor\Platform\Concerns\HasLandingPage;

class TestModel extends \Illuminate\Database\Eloquent\Model
{

    protected $guarded = [];

    use HasLandingPage;
}