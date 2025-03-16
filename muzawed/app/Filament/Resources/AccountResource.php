<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Filament\Forms\Components\Select;
class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    public static function getNavigationLabel(): string
    {
        return __('filamentnav.accounts');
    }

    public static function getNavigationGroup(): string
    {
        return __('filamentnav.memberships'); 
    }
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label(__('account.name')),

            Forms\Components\Select::make('type')
                ->options([
                    'enterprise' => __('account.enterprise'),
                    'saas' => __('account.saas'),
                ])
                ->required()
                ->label(__('account.type')),

            Forms\Components\FileUpload::make('logo')
                ->image()
                ->nullable()
                ->disk(config('filesystems.default'))
                ->label(__('account.logo')),

            Forms\Components\Textarea::make('description_en')
                ->nullable()
                ->label(__('account.description_en')),

            Forms\Components\Textarea::make('description_ar')
            ->nullable()
            ->label(__('account.description_ar')),

            Forms\Components\Section::make('Admin User')
                ->schema([
                    Forms\Components\TextInput::make('admin_name')
                        ->label(__('account.admin_name'))
                        ->required(),

                    Forms\Components\TextInput::make('admin_email')
                        ->label(__('account.admin_email'))
                        ->email()
                        ->unique(User::class, 'email')
                        ->required(),

                    Forms\Components\TextInput::make('admin_password')
                        ->label(__('account.admin_password'))
                        ->password()
                        ->required(),
                ]),

            Forms\Components\Repeater::make('members')
                ->label('Member Users')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('account.member_name'))
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->label('account.member_email')
                        ->email()
                        ->unique(User::class, 'email')
                        ->required(),

                    Forms\Components\TextInput::make('password')
                        ->label(__('account.member_password'))
                        ->password()
                        ->required(),
                ])
                ->createItemButtonLabel(__('account.add_member')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label(__('account.name')),
                Tables\Columns\TextColumn::make('type')->sortable()->label(__('account.type')),
                Tables\Columns\ImageColumn::make('logo')->label(__('account.logo')),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y')->label(__('account.created_at')),
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
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
