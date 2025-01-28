<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProducts extends CreateRecord
{
    protected static string $resource = ProductsResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect to the index page after creation
        return $this->getResource()::getUrl('index');
    }
}
