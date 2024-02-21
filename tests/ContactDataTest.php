<?php

use Envor\Platform\Tests\Fixtures\TestModel;
use Illuminate\Support\Facades\Schema;
use Livewire\Volt\Volt;

beforeEach(function () {

    Schema::create('test_models', function ($table) {
        $table->id();
        $table->text('contact_data')->nullable();
        $table->timestamps();
    });

    $this->model = TestModel::create();
});

it('can update contact data', function () {


    $this->model->updateContactData([
        'name' => 'John Doe',
        'email' => 'me@test.com',
        'phone' => '123-456-7890',
        'address' => [
            'street' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'NY',
            'zip' => '12345',
            'country' => 'USA',
        ],
    ]);

    expect($this->model->fresh()->contactData->name)->toBe('John Doe');
    expect($this->model->fresh()->contactData->address->street)->toBe('123 Main St');

    $this->model->updateContactData([
        'name' => 'Jane Doe',
        'address' => [
            'street' => '124 Main St',
        ],
    ]);

    expect($this->model->fresh()->contactData->name)->toBe('Jane Doe');
    expect($this->model->fresh()->contactData->email)->toBe('me@test.com');
    expect($this->model->fresh()->contactData->phone)->toBe('123-456-7890');
    expect($this->model->fresh()->contactData->address->street)->toBe('124 Main St');
    expect($this->model->fresh()->contactData->address->city)->toBe('Anytown');
    expect($this->model->fresh()->contactData->address->state)->toBe('NY');
    expect($this->model->fresh()->contactData->address->zip)->toBe('12345');
    expect($this->model->fresh()->contactData->address->country)->toBe('USA');
});

it('can update contact data using a contact data object', function () {

    $this->model->updateContactData(new \Envor\Platform\Data\ContactData(
        name: 'John Doe',
        email: 'me@test.com',
        phone: '123-456-7890',
        address: new \Envor\Platform\Data\AddressData(
            street: '123 Main St',
            city: 'Anytown',
            state: 'NY',
            zip: '12345',
            country: 'USA',
        ),
    ));

    expect($this->model->fresh()->contactData->name)->toBe('John Doe');
    expect($this->model->fresh()->contactData->email)->toBe('me@test.com');
    expect($this->model->fresh()->contactData->phone)->toBe('123-456-7890');
    expect($this->model->fresh()->contactData->address->street)->toBe('123 Main St');
    expect($this->model->fresh()->contactData->address->city)->toBe('Anytown');
    expect($this->model->fresh()->contactData->address->state)->toBe('NY');
    expect($this->model->fresh()->contactData->address->zip)->toBe('12345');
    expect($this->model->fresh()->contactData->address->country)->toBe('USA');
});

it('can update contact data using livewire volt', function () {

    Volt::test('update-contact-info-form', ['model' => $this->model])
        ->set('readonly', false)
        ->set('data', [
            'name' => 'John Doe',
            'email' => 'me@test.com',
            'phone' => '123-456-7890',
            'address' => [
                'street' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'NY',
                'zip' => '12345',
                'country' => 'USA',
            ],
        ])
        ->call('updateContactData');

    expect($this->model->fresh()->contactData->name)->toBe('John Doe');
    expect($this->model->fresh()->contactData->email)->toBe('me@test.com');
    expect($this->model->fresh()->contactData->phone)->toBe('123-456-7890');
    expect($this->model->fresh()->contactData->address->street)->toBe('123 Main St');
    expect($this->model->fresh()->contactData->address->city)->toBe('Anytown');
    expect($this->model->fresh()->contactData->address->state)->toBe('NY');
    expect($this->model->fresh()->contactData->address->zip)->toBe('12345');
    expect($this->model->fresh()->contactData->address->country)->toBe('USA');
});