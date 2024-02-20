<?php

use Envor\Platform\Tests\Fixtures\TestModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Livewire\Volt\Volt;

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

test('a landing page can be viewed', function () {
    $this->model->updateLandingPage(UploadedFile::fake()->image('landing-page.jpg'));

    $response = $this->get($this->model->fresh()->landing_page_url);

    $response->assertStatus(200);
});

it('can create a landing page using livewire volt', function () {

    // create and html file
    $uploadedFile = UploadedFile::fake()->create('landing-page.html', 100);

    Volt::test('update-landing-page-form', ['model' => $this->model])
        ->set('landing_page', $uploadedFile)
        ->call('updateLandingPage');

    expect($this->model->fresh()->landingPagePath())->not->toBeNull();
});

it('can delete a landing page using livewire volt', function () {
    $this->model->updateLandingPage(UploadedFile::fake()->image('landing-page.jpg'));

    Volt::test('update-landing-page-form', ['model' => $this->model])
        ->call('deleteLandingPage');

    expect($this->model->fresh()->landingPagePath())->toBeNull();
});