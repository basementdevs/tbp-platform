<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Models\Settings\Settings;
use App\Tables\Columns\TextEffectColumn;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;

    protected static ?string $slug = 'settings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->disabledOn('create')
                    ->content(fn (?Settings $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->disabledOn('create')
                    ->content(fn (?Settings $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->disabledOn('update')
                    ->required(),

                TextInput::make('channel_id')
                    ->label('Channel')
                    ->disabledOn('update')
                    ->required(),

                Select::make('color_id')
                    ->label('Color')
                    ->relationship('color', 'name')
                    ->required(),

                Select::make('pronouns')
                    ->options(collect(config('extension.pronouns'))->mapWithKeys(fn ($value, $key) => [$key => $value['name']])),

                Select::make('occupation_id')
                    ->label('Occupation')
                    ->relationship('occupation', 'name')
                    ->required(),

                Select::make('effect_id')
                    ->label('Effect')
                    ->relationship('effect', 'name')
                    ->required(),

                Toggle::make('enabled')
                    ->label('Enabled')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('channel_id')
                    ->label('Channel')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'global' => 'warning',
                        default => 'primary'
                    }),
                TextColumn::make('occupation.name'),
                ColorColumn::make('color.hex'),
                TextEffectColumn::make('effect.name'),
                IconColumn::make('enabled')
                    ->boolean(),

            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSettings::route('/create'),
            'edit' => Pages\EditSettings::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
