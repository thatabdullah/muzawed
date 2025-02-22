<?php

namespace App\Filament\Resources\IntegrationPartnerResource\Pages;

use App\Filament\Resources\IntegrationPartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIntegrationPartners extends ListRecords
{
    protected static string $resource = IntegrationPartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
