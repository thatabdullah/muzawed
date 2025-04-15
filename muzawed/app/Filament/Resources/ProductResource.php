<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\MultiSelect;
use App\Models\Tag;
use App\Model\IntegrationPartner;
use App\Models\Account;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static function getNavigationLabel(): string
    {
        return __('filamentnav.products');
    }

    public static function getNavigationGroup(): string
    {
        return __('filamentnav.products'); 
    }

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket-square';
    

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label(__('product.name'))
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('account_id')
            ->label(__('product.account'))
            ->options(Account::where('type', 'saas')->pluck('name', 'id')) // searchs by name and stores by id
            ->required()
            ->searchable(),   
            
            Forms\Components\Textarea::make('description_en')
                ->label(__('product.description_en'))
                ->nullable(),

            Forms\Components\Textarea::make('description_ar')
                ->label(__('product.description_ar'))
                ->nullable(),
            
            Forms\Components\Select::make('category_id')
                ->label(__('product.category'))
                ->options(function () {
                    return \App\Models\Category::all()->pluck('name_en', 'id');
                })
                ->searchable()
                ->required(),
            

           /* Forms\Components\TextInput::make('currency')
                ->label('Currency')
                ->default('SAR')
                ->maxLength(3), */
            
            
            Forms\Components\Select::make('pricing_model')
                ->label(__('product.pricing_model'))
                ->options([
                    'subscription' => __('product.subscription'),
                    'one-time' => __('product.one_time'),
                    'pay-as-you-go' => __('product.payasyougo'),
                ])
                ->required(),
            

            Forms\Components\Textarea::make('detailed_description_en')
            ->label(__('product.detailed_description_en'))
            ->nullable(),
            
            Forms\Components\Textarea::make('detailed_description_ar')
                ->label(__('product.detailed_description_ar'))
                ->nullable(),

            Forms\Components\Repeater::make('key_features_en')
            ->label(__('product.key_features_en'))
            ->schema([
                Forms\Components\TextInput::make('product.name')->required(),
                Forms\Components\TextInput::make('product.description_en')->required(),
            ])
            ->default([])
            ->nullable()
            ->collapsible()
            ->cloneable()
            ->grid(2),

            Forms\Components\Repeater::make('key_features_ar')
            ->label(__('product.key_features_ar'))
            ->schema([
                Forms\Components\TextInput::make('product.name')->required(),
                Forms\Components\TextInput::make('product.description_en')->required(),
            ])
            ->default([])
            ->nullable()
            ->collapsible()
            ->cloneable()
            ->grid(2),

            Forms\Components\TextInput::make('documentation_url')
                ->label(__('product.documentation_url'))
                ->nullable(),

            Forms\Components\FileUpload::make('video')
            ->nullable()
            ->disk(config('filesystems.default'))
            ->label(__('product.video')),

            
            Forms\Components\TextInput::make('version')
                ->label('Version')
                ->nullable(),

            Forms\Components\Textarea::make('version_features_en')
            ->label(__('product.version_features_en'))
            ->nullable(),
            
            Forms\Components\Textarea::make('version_features_ar')
            ->label(__('product.version_features_ar'))
            ->nullable(),

            
            Forms\Components\MultiSelect::make('integrationPartners')
            ->relationship('integrationPartners', 'name') // 'name' is the column from the IntegrationPartner model
            ->label(__('product.integration_partners'))
            ->preload()
            ->searchable(),


            Forms\Components\TextInput::make('support_email')
                ->label(__('product.support_email'))
                ->nullable(),

            Forms\Components\TextInput::make('support_hours')
            ->label(__('product.support_hours'))
                ->nullable(),


            Forms\Components\TextInput::make('product_link')
                ->label(__('product.product_link'))
                ->nullable(),

            Forms\Components\MultiSelect::make('tags')
            ->relationship('tags', 'name_en') // 'name' is the column from the tags table
            ->label(__('product.tags'))
            ->preload()
            ->searchable(),

            Forms\Components\Checkbox::make('active')
            ->label(__('product.active'))
            ->default(true),

            Forms\Components\Checkbox::make('featured')
                ->label(__('product.featured'))
                ->default(false),

            Forms\Components\FileUpload::make('main_image')
            ->label(__('product.main_Image'))
            ->image()
            ->disk(config('filesystems.default'))
            ->nullable(),

            Forms\Components\Repeater::make('media_gallery')
                ->label(__('product.media_gallery'))
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->label(__('product.image_or_video'))
                        ->disk(config('filesystems.default'))
                        ->nullable(),
                ])
                ->nullable(),                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label(__('product.name')),
                Tables\Columns\TextColumn::make('account.name')->sortable()->searchable()->label(__('product.account')),
                Tables\Columns\TextColumn::make('category.name_en')->label(__('product.category'))->sortable(),
                Tables\Columns\BooleanColumn::make('active')->sortable()->label(__('product.active')),
                Tables\Columns\BooleanColumn::make('featured')->sortable()->label(__('product.featured')),
                Tables\Columns\TextColumn::make('average_rating')->sortable()->label(__('product.average_rating')),
                Tables\Columns\TextColumn::make('review_count')->sortable()->label(__('product.review_count')),
                Tables\Columns\TextColumn::make('tags.name_en')
                ->label(__('product.tags'))
                ->badge() // Displays tags in a badge format
                ->separator(', '), 
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
            //TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
