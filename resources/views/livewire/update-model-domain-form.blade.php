<?php

use function Livewire\Volt\{state, mount};

state([
    'model' => null,
    'data' => [],
    'readonly' => true,
]);

mount(fn ($model) => $this->model = $model);

$updateModelDomain = function () {

    if($this->readonly) return;

    $this->resetErrorBag();
    $input = $this->data;

    Validator::make($input, [
        'domain' => ['nullable', 'string', 'max:255'],
    ])->validate();

    $this->model->forceFill(['domain' => $input['domain']])->save();

    $this->dispatch('saved');
};?>

<div>
    <x-platform::form-section submit="updateModelDomain">
        <x-slot name="title">
            {{ __('Domain') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The domain where these resources will be displayed.') }}
        </x-slot>

        <x-slot name="form">

            <!-- Company Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-platform::label for="domain" value="{{ __('Domain') }}" />

                <x-platform::input id="domain"
                            type="text"
                            class="block w-full mt-1"
                            wire:model.defer="data.domain"
                            :disabled="$this->readonly" />

                <x-platform::input-error for="domain" class="mt-2" />
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