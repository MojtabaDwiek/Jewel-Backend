<?php

namespace App\Filament\Resources\RetailersResource\Pages;

use App\Filament\Resources\RetailersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRetailers extends CreateRecord
{
    protected static string $resource = RetailersResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect to the index page after creation
        return $this->getResource()::getUrl('index');
    }
}