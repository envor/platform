<?php

use Envor\Platform\Tests\Fixtures\TestModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {

    Schema::create('test_models', function ($table) {
        $table->id();

        $table->timestamps();
    });

    $this->model = TestModel::create();
});

it('can create a landing page', function () {

    $this->model->updateLandingPage(UploadedFile::fake()->image('landing-page.jpg'));

    expect($this->model->fresh()->landingPagePath())->not->toBeNull();
});

it('can delete a landing page', function () {
    $this->model->updateLandingPage(UploadedFile::fake()->image('landing-page.jpg'));

    $this->model->fresh()->deletelandingPage();

    expect($this->model->fresh()->landingPagePath())->toBeNull();
});

test('a landig page can be viewed', function () {
    $this->model->updateLandingPage(UploadedFile::fake()->image('landing-page.jpg'));

    $response = $this->get($this->model->fresh()->landing_page_url);

    $response->assertStatus(200);
});
