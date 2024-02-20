<?php

use Envor\Platform\Tests\Fixtures\TestModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Livewire\Volt\Volt;

beforeEach(function () {
    Schema::connection(config('database.platform'))->create('test_models', function ($table) {
        $table->id();
        $table->string('profile_photo_path')->nullable();
        $table->timestamps();
    });

    $this->model = TestModel::create();
});

it('can upload a logo', function () {
    $photo = UploadedFile::fake()->image('photo.jpg');

    Volt::test('update-logo-form', ['model' => $this->model])
        ->set('photo', $photo)
        ->call('updateProfilePhoto');

    expect($this->model->fresh()->profile_photo_path)->not->toBeNull();
});

it('can delete a logo', function () {
    $photo = UploadedFile::fake()->image('photo.jpg');

    $this->model->update(['profile_photo_path' => $photo]);

    Volt::test('update-logo-form', ['model' => $this->model])
        ->call('deleteProfilePhoto');

    expect($this->model->fresh()->profile_photo_path)->toBeNull();
});
