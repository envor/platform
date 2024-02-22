<?php

use function Livewire\Volt\{state, mount};

state([
    'model' => null,
    'data' => [],
    'readonly' => true,
]);

mount(function ($model) {
        
        $this->model = $model;

        $this->data = $model->contact_data->toArray();

        if ($this->data['fax'] == config('platform.empty_phone')) {
            $this->data['fax'] = null;
        }
        if ($this->data['phone'] == config('platform.empty_phone')) {
            $this->data['phone'] = null;
        }
        if ($this->data['email'] == '') {
            $this->data['email'] = null;
        }
});


$updateContactData = function () {

    if($this->readonly) return;

    $this->resetErrorBag();
    $input = $this->data;

    Validator::make($input, [
        'address.city' => ['nullable', 'string', 'max:255'],
        'address.state' => ['nullable', 'string', 'max:255'],
        'address.zip' => ['nullable', 'string', 'max:255'],
        'address.street' => ['nullable', 'string', 'max:255'],
        'address.country' => ['nullable', 'string', 'max:255'],
        'address.lineTwo' => ['nullable', 'string', 'max:255'],
        'website' => ['nullable', 'url'],
        'email' => ['nullable', 'email'],
        'phone' => ['nullable', 'string'],
        'fax' => ['nullable', 'string'],
        'name' => ['nullable', 'string', 'max:255',],
    ])->validate();

    $this->model->updateContactData($input);

    $this->dispatch('saved');
};

?>
<div>
    <x-platform::form-section submit="updateContactData">
        <x-slot name="title">
            {{ __('Contact Info') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The Business or organization address and contact details that will be used for invoices and other documents.') }}
        </x-slot>

        <x-slot name="form">

            <!-- Company Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-platform::label for="name" value="{{ __('Name') }}" />

                <x-platform::input id="name"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.name"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="name" class="mt-2" />
            </div>

            <!-- Company Phone -->
            <div class="col-span-6 sm:col-span-4">
                <x-platform::label for="phone" value="{{ __('Phone') }}" />

                <x-platform::input id="phone"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.phone"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="phone" class="mt-2" />
            </div>

            <!-- Company Phone -->
            <div class="col-span-6 sm:col-span-4">
                <x-platform::label for="fax" value="{{ __('Fax') }}" />

                <x-platform::input id="fax"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.fax"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="fax" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-platform::label for="email" value="{{ __('Email') }}" />

                <x-platform::input id="email"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.email"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="email" class="mt-2" />
            </div>

            <!-- Company Address -->

            <div class="col-span-6 sm:col-span-4">
                <x-platform::label for="street" value="{{ __('Address Line One') }}" />

                <x-platform::input id="street"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.address.street"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="street" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-platform::label for="lineTwo" value="{{ __('Address Line Two') }}" />

                <x-platform::input id="lineTwo"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.address.lineTwo"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="lineTwo" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">

                <x-platform::label for="lineTwo" value="{{ __('City') }}" />

                <x-platform::input id="city"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.address.city"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="city" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">

                <x-platform::label for="state" value="{{ __('State') }}" />

                <x-platform::input id="state"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.address.state"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="state" class="mt-2" />

            </div>

            <div class="col-span-6 sm:col-span-4">

                <x-platform::label for="zip" value="{{ __('Zip') }}" />

                <x-platform::input id="zip"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.address.zip"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="zip" class="mt-2" />

            </div>

            <div class="col-span-6 sm:col-span-4">

                <x-platform::label for="country" value="{{ __('Country') }}" />

                <x-platform::input id="country"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.address.country"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="country" class="mt-2" />

            </div>


        </x-slot>

        @if (! $this->readonly)
            <x-slot name="actions">
                <x-platform::action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-platform::action-message>

                <x-platform::button>
                    {{ __('Save') }}
                </x-platform::button>
            </x-slot>
        @endif
    </x-platform::form-section>

</div>