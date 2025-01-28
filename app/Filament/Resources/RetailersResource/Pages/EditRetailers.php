<?php

namespace App\Filament\Resources\RetailersResource\Pages;

use App\Filament\Resources\RetailersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRetailers extends EditRecord
{
    protected static string $resource = RetailersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
