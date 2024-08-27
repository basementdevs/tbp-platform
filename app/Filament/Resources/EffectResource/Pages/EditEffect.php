<?php

namespace App\Filament\Resources\EffectResource\Pages;

use App\Filament\Resources\EffectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditEffect extends EditRecord
{
    protected static string $resource = EffectResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record = parent::handleRecordUpdate($record, $data);

        \Artisan::call('app:ges');

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
