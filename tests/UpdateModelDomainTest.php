<?php

use Envor\Platform\Tests\Fixtures\TestModel;
use Illuminate\Support\Facades\Schema;
use Livewire\Volt\Volt;

beforeEach(function () {

    Schema::create('test_models', function ($table) {
        $table->id();
        $table->string('domain')->nullable();
        $table->timestamps();
    });

    $this->model = TestModel::create();
});

it('can update a domain', function () {

    $this->model->update(['domain' => 'example.com']);

    expect($this->model->fresh()->domain)->toBe('example.com');
});

it('can update a domain using livewire volt', function () {

    Volt::test('update-model-domain-form', ['model' => $this->model])
        ->set('readonly', false)
        ->set('data.domain', 'example.com')
        ->call('updateModelDomain');

    expect($this->model->fresh()->domain)->toBe('example.com');
});