<?php

namespace App\Filament\Resources\EffectResource\Pages;

use App\Filament\Resources\EffectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEffects extends ListRecords
{
    protected static string $resource = EffectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
