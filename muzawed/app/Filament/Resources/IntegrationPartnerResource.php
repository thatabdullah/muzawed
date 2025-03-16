<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntegrationPartnerResource\Pages;
use App\Filament\Resources\IntegrationPartnerResource\RelationManagers;
use App\Models\IntegrationPartner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;

class IntegrationPartnerResource extends Resource
{
    protected static ?string $model = IntegrationPartner::class;

    public static function getNavigationLabel(): string
    {
        return __('filamentnav.integration');
    }

    public static function getNavigationGroup(): string
    {
        return __('filamentnav.products'); 
    }

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('integration.name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('website')
                            ->label(__('integration.website'))
                            ->url()
                            ->nullable(),

                        Forms\Components\FileUpload::make('logo')
                        ->image()
                        ->nullable()
                        ->disk(config('filesystems.default'))
                        ->label(__('integration.logo')),    

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label(__('integration.name')),
                Tables\Columns\TextColumn::make('website')->sortable()->label(__('integration.website')),
                Tables\Columns\TextColumn::make('created_at')->label(__('integration.created_at'))->dateTime('M d, Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIntegrationPartners::route('/'),
            'create' => Pages\CreateIntegrationPartner::route('/create'),
            'edit' => Pages\EditIntegrationPartner::route('/{record}/edit'),
        ];
    }
}
