<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    public static function getNavigationLabel(): string
    {
        return __('filamentnav.tags');
    }

    public static function getNavigationGroup(): string
    {
        return __('filamentnav.products'); 
    }

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_en')
                ->required()
                ->label(__('tag.name_en'))
                ->unique(ignoreRecord: true)
                ->maxLength(255),

                Forms\Components\TextInput::make('name_ar')
                ->required()
                ->label(__('tag.name_ar'))
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                ->sortable()
                ->searchable()
                ->label(__('tag.name_en')),

                Tables\Columns\TextColumn::make('name_ar')
                ->sortable()
                ->searchable()
                ->label(__('tag.name_ar')),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->label(__('tag.created_at'))
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
