<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function Livewire\Volt\{state, usesFileUploads};

state([
    'photo' => null,
    'model' => null,
]);

usesFileUploads();

$updateProfilePhoto = function () {
    Validator::make([$this?->photo], [
        'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
    ])->validateWithBag('updateProfileInformation');

    if ($this->photo) {
        DB::connection(config('database.platform'))->transaction(function () {
            $this->model->updateProfilePhoto($this->photo);
        });
    }

    $this->dispatch('saved');
};

$deleteProfilePhoto = function () {
    DB::connection(config('database.platform'))->transaction(function () {
        $this->model->deleteProfilePhoto();
    });

    $this->dispatch('saved');
};?>

<x-platform::form-section submit="updateProfilePhoto">
    <x-slot name="title">
        {{ __('Logo') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Your Logo.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-platform::label for="photo" value="{{ __('Logo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $model->profile_photo_url }}" alt="{{ $model->name }}" class="object-cover w-20 h-20 rounded-full">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>
             
                <x-platform::secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Logo') }}
                </x-platform::secondary-button>

                @if ($model->profile_photo_path)
                    <x-platform::secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Logo') }}
                    </x-platform::secondary-button>
                @endif
        
                <x-platform::input-error for="photo" class="mt-2" />
            </div>
    </x-slot>

    <x-slot name="actions">
        <x-platform::action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-platform::action-message>

        <x-platform::button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-platform::button>
    </x-slot>
</x-platform::form-section>