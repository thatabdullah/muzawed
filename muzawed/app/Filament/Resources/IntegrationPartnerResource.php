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

    protected static ?string $navigationLabel = 'Integration Partners';

    protected static ?string $navigationGroup = 'Products';

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->nullable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('website')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime('M d, Y'),
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
