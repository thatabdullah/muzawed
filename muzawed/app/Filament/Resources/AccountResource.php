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
class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationGroup = 'Membership';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('type')
                ->options([
                    'enterprise' => 'Enterprise',
                    'saas' => 'SaaS',
                ])
                ->required(),

            Forms\Components\FileUpload::make('logo')
                ->image()
                ->nullable(),

            Forms\Components\Textarea::make('description')
                ->nullable(),

            Forms\Components\Section::make('Admin User')
                ->schema([
                    Forms\Components\TextInput::make('admin_name')
                        ->label('Admin Name')
                        ->required(),

                    Forms\Components\TextInput::make('admin_email')
                        ->label('Admin Email')
                        ->email()
                        ->unique(User::class, 'email')
                        ->required(),

                    Forms\Components\TextInput::make('admin_password')
                        ->label('Admin Password')
                        ->password()
                        ->required(),
                ]),

            Forms\Components\Repeater::make('members')
                ->label('Member Users')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Member Name')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->label('Member Email')
                        ->email()
                        ->unique(User::class, 'email')
                        ->required(),

                    Forms\Components\TextInput::make('password')
                        ->label('Member Password')
                        ->password()
                        ->required(),
                ])
                ->createItemButtonLabel('Add Member'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('type')->sortable(),
                Tables\Columns\ImageColumn::make('logo'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y'),
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
