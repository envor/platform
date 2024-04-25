<?php

use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{state, mount, usesFileUploads};

usesFileUploads();

state([
    'landing_page' => null, 
    'model' => null
]);

mount( fn($model) => $this->model = $model );

$updateLandingPage = function () {

    Validator::make(
        [$this->landing_page],
        ['landing_page' => ['nullable', 'file', 'mimes:html'],]
    )->validate();

    if($this->landing_page) {
        DB::connection(config('database.platform'))->transaction(
            function () {
                $this->model->updateLandingPage($this->landing_page);
            }
        );

        $this->dispatch('saved');
    }
};

$downloadLandingPage = function () {
    return response()->download(
        Storage::disk($this->model->landingPageDisk())->path($this->model->landingPagePath())
    );
};

$deleteLandingPage = function () {
    $this->model->deleteLandingPage();
    $this->dispatch('saved');
};?>


<x-platform::form-section submit="updateLandingPage">
    <x-slot name="title">
        {{ __('Landing Page') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Your Landing Page. You may customize it by uploading an html file.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Landing Page -->
        <div x-data="{pageName: null, pagePreview: null}" class="col-span-6 sm:col-span-4">
            <!-- Landing Page File Input -->
            <input type="file" class="hidden"
                        wire:model="landing_page"
                        x-ref="page"
                        x-on:change="
                                pageName = $refs.page.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    pagePreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.page.files[0]);
                        " />

            <x-platform::label for="landing_page" value="{{ __('Landing Page') }}" />
            <div class="">

                <!-- Current Landing Page -->
                <div class="mt-2" x-show="! pagePreview">
                    <iframe 
                        src="{{ $this->model?->landing_page_url }}" 
                        alt="{{ $this->model->name }}" 
                        class="w-full h-screen"
                        ></iframe>
                </div>
                
                <!-- New Landing Page Preview -->
                <div class="mt-2" x-show="pagePreview" style="display: none;">
                    <iframe class="w-100" :src="pagePreview">
                    </iframe>
                </div>
            </div>
                
            <div class="col-span-6 sm:col-span-4">

                <x-platform::secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.page.click()">
                    <span>{{ __('Replace') }}</span>
                </x-platform::secondary-button>
                
                @if ($this->model?->landingPage()->exists())
                    <x-platform::secondary-button type="button" class="mt-2 mr-2" wire:click="downloadLandingPage" x-on:click="pagePreview=false" >
                        <span>{{ __('Download') }}</span>
                    </x-platform::secondary-button>

                    <x-platform::secondary-button type="button" class="mt-2 mr-2" wire:click="deleteLandingPage" x-on:click="pagePreview=false" >
                        Delete
                    </x-platform::secondary-button>
                @endif
                
                <x-platform::secondary-button-link class="mt-2" target="_blank" href="{{ $this->model?->url }}">
                    <span>Visit</span>
                </x-platform::secondary-button-link>
            </div>
            <x-platform::input-error for="landing_page" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-platform::action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-platform::action-message>

        <x-platform::button wire:loading.attr="disabled" wire:target="page">
            {{ __('Save') }}
        </x-platform::button>
    </x-slot>
</x-platform::form-section>
