<?php

namespace Envor\Platform\Concerns;

use Envor\Platform\Models\LandingPage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

trait HasLandingPage
{

    public function landingPage()
    {
        return $this->morphOne(LandingPage::class, 'model');
    }

        /**
     * Update the landing page.
     *
     * @return void
     */
    public function updateLandingPage(UploadedFile $page)
    {
        tap($this->landingPagePath(), function ($previous) use ($page) {
            $this->landingPage()->save(LandingPage::forceCreate([
                'landing_page_path' => $page->storePublicly('landing-pages', ['disk' => $this->landingPageDisk()])
            ]));

            if ($previous) {
                Storage::disk($this->landingPageDisk())->delete($previous);
            }
        });
    }

    public function landingPagePath()
    {
        return $this->landingPage?->landing_page_path;
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteLandingPage()
    {
        if (is_null($this->landingPagePath())) {
            return;
        }

        Storage::disk($this->landingPageDisk())->delete($this->landingPagePath());

        $this->landingPage->forceFill([
            'landing_page_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getLandingPageUrlAttribute()
    {
        // return '/v1/landing-page/'. $this->slug;

        return $this->landingPagePath()
                    ? str_replace(url(''), '', '/v1/landing-page/'.$this->landingPage?->uuid)
                    : $this->defaultlandingPageUrl();

        return $this->landingPage()
                    ? str_replace(url(''), '', Storage::disk($this->landingPageDisk())->url($this->landingPage()))
                    : $this->defaultlandingPageUrl();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getLandingPageThumbUrlAttribute()
    {
        return $this->landingPagePath()
                    ? Storage::disk($this->landingPageDisk())->url($this->landingPagePath().'.png')
                    : $this->defaultlandingPageUrl();
    }

    public function downloadLandingPage()
    {
        return Storage::disk($this->landingPageDisk())->download($this->landingPagePath());
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultlandingPageUrl()
    {

        $uuid = $this->landingPage?->uuid ?? '00000000-0000-0000-0000-000000000000';

        return url(config('platform.default_landing_page', '/v1/landing-page/'.$uuid));
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    public function landingPageDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('platform.landing_page_disk', 'public');
    }

    public function url(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => (isset($attributes['domain']) && ! empty($attributes['domain'])) ? $this->preferHttps($attributes['domain']) : $this->landing_page_url,
        );
    }

    /**
     * Use laravel http client to check if domain supports https
     */
    function preferHttps(string $domainName): string
    {
        try {
            $response = Http::get("https://{$domainName}");
            if ($response && $response->status() === 200) {
                return "https://{$domainName}";
            }
        } catch (\Exception $e) {
            //do nothing
        }

        return "http://{$domainName}";
    }
}