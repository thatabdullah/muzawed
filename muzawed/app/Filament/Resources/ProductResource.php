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

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $navigationGroup = 'Products';

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket-square';
    

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Product Name')
                ->required()
                ->maxLength(255),
            
            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->nullable(),
            
            Forms\Components\Select::make('category_id')
                ->label('Category')
                ->options(function () {
                    return \App\Models\Category::all()->pluck('name', 'id');
                })
                ->searchable()
                ->required(),
            

           /* Forms\Components\TextInput::make('currency')
                ->label('Currency')
                ->default('SAR')
                ->maxLength(3), */
            
            Forms\Components\TextInput::make('discount_percentage')
                ->label('Discount Percentage')
                ->numeric()
                ->nullable(),
            
            Forms\Components\Select::make('pricing_model')
                ->label('Pricing Model')
                ->options([
                    'subscription' => 'Subscription',
                    'one-time' => 'One-time',
                    'pay-as-you-go' => 'Pay as you go',
                ])
                ->required(),
            
            Forms\Components\TextInput::make('trial_period_days')
                ->label('Trial Period (Days)')
                ->numeric()
                ->nullable(),
    

            Forms\Components\Textarea::make('detailed_description')
                ->label('Detailed Description')
                ->nullable(),

            Forms\Components\Textarea::make('key_features')
                ->label('Key Features')
                ->nullable(),

            Forms\Components\TextInput::make('documentation_url')
                ->label('Documentation URL')
                ->nullable(),

            Forms\Components\TextInput::make('video_url')
                ->label('Video URL')
                ->nullable(),

            
            Forms\Components\TextInput::make('version')
                ->label('Version')
                ->nullable(),

            Forms\Components\Textarea::make('version_features')
                ->label('Version Features')
                ->nullable(),

            
            Forms\Components\MultiSelect::make('integrationPartners')
            ->relationship('integrationPartners', 'name') // 'name' is the column from the IntegrationPartner model
            ->label('Integration Partners')
            ->preload()
            ->searchable(),

            /*Forms\Components\TextInput::make('average_rating')
                ->label('Average Rating')
                ->numeric()
                ->default(0)
                ->minValue(0)
                ->maxValue(5), */

          /*  Forms\Components\TextInput::make('review_count')
                ->label('Review Count')
                ->numeric()
                ->default(0), */

            Forms\Components\TextInput::make('support_email')
                ->label('Support Email')
                ->nullable(),

            Forms\Components\TextInput::make('support_hours')
                ->label('Support Hours')
                ->nullable(),

            Forms\Components\TextInput::make('renewal_period_days')
                ->label('Renewal Period (Days)')
                ->numeric()
                ->nullable(),

            Forms\Components\TextInput::make('product_link')
                ->label('Product Link')
                ->nullable(),

            Forms\Components\MultiSelect::make('tags')
            ->relationship('tags', 'name') // 'name' is the column from the tags table
            ->label('Tags')
            ->preload()
            ->searchable(),

            Forms\Components\Checkbox::make('active')
            ->label('Active')
            ->default(true),

            Forms\Components\Checkbox::make('featured')
                ->label('Featured')
                ->default(false),

                Forms\Components\FileUpload::make('main_image')
                ->label('Main Image')
                ->image()
                ->nullable(),

            Forms\Components\Repeater::make('media_gallery')
                ->label('Media Gallery')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->label('Image or Video')
                        ->nullable(),
                ])
                ->nullable(),                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable(),
                Tables\Columns\BooleanColumn::make('active')->sortable(),
                Tables\Columns\BooleanColumn::make('featured')->sortable(),
                Tables\Columns\TextColumn::make('average_rating')->sortable(),
                Tables\Columns\TextColumn::make('review_count')->sortable(),
                Tables\Columns\TextColumn::make('tags.name')
                ->label('Tags')
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
