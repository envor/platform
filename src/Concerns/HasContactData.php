<?php

namespace Envor\Platform\Concerns;

use Envor\Platform\Data\AddressData;
use Envor\Platform\Data\ContactData;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasContactData
{
    public function contactData(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $this->getContactData($attributes),
            set: fn ($value, $attributes) => config('platform.stores_contact_info') ? $this->buildContactData($value, $attributes) : null,
        );
    }

    public function buildContactData(array|string|ContactData $contactData, $attributes): string
    {
        $originalContactData = (array) $this->getContactData($attributes);

        $newContactData = $contactData instanceof ContactData ? $contactData->toArray() : $contactData;

        $newContactData = is_string($newContactData) ? json_decode($newContactData, true) : $newContactData;

        if (isset($newContactData['address']) && isset($originalContactData['address'])) {
            $newContactData['address'] = array_merge((array) $originalContactData['address'], $newContactData['address']);
        }

        $finalContactData = array_merge($originalContactData, $newContactData);

        return json_encode($finalContactData);
    }

    public function updateContactData(array|string|ContactData $contactData): bool
    {
        return $this->update([
            'contact_data' => $contactData,
        ]);
    }

    public function getContactData($attributes): ?ContactData
    {

        if (! config('platform.stores_contact_info')) {
            return null;
        }

        $companyData = json_decode($attributes['contact_data'] ?? '', true);

        $address = new AddressData(
            city: $companyData['address']['city'] ?? null,
            state: $companyData['address']['state'] ?? null,
            zip: $companyData['address']['zip'] ?? null,
            street: $companyData['address']['street'] ?? null,
            country: $companyData['address']['country'] ?? 'USA',
            lineTwo: $companyData['address']['lineTwo'] ?? null,
        );

        return new ContactData(
            name: $companyData['name'] ?? $attributes['name'] ?? null,
            landingPage: $companyData['landingPage'] ?? null,
            address: $address,
            logoUrl: null,
            logoPath: null,
            phone: $companyData['phone'] ?? config('platform.empty_phone'),
            fax: $companyData['fax'] ?? config('platform.empty_phone'),
            email: $companyData['email'] ?? null,
            website: $companyData['website'] ?? null,
        );
    }
}
