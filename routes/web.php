<?php

use Illuminate\Support\Facades\Storage;

Route::get('/v1/landing-page/{uuid}', function ($uuid) {

    $landingPage = \Envor\Platform\Models\LandingPage::where('uuid', $uuid)->first();

    // if the team has an html landing page, return it
    if ($landingPage?->landing_page_path) {
        return response()->file(Storage::disk($landingPage->model->landingPageDisk())->path($landingPage->landing_page_path));
    }

    return view('welcome');

})->name('platform.landing-page');