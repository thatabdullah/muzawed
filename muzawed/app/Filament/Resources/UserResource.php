<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Account; // to use the account model
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Membership';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form // here we have built the form
    {
        return $form
            ->schema([
                Section::make('User Information')->schema([
                    Grid::make(2)->schema([
                        Forms\components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),

                        Forms\components\TextInput::make('email')
                            ->email()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->required(),
                        
                        Forms\components\Select::make('account_id')
                        ->label('Account')
                        ->options(Account::all()->pluck('name', 'id')) // searchs by name and stores by id
                        ->searchable() 
                        ->nullable(), // (for indie users)*/

                        Forms\components\Select::make('role')
                            ->options([
                                'admin' => 'Admin',
                                'member' => 'Member',
                            ])
                            ->default('member')
                            ->required(),

                        Forms\components\TextInput::make('password')
                            ->password()
                            ->required(fn($record) => $record === null)
                            ->minLength(8)
                            ->dehydrateStateUsing(fn($state) => bcrypt($state))
                            ->visible(fn($record) => $record === null),
                    ]),
                ]),

                Section::make('Settings')->schema([
                    Forms\components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    Forms\components\DateTimePicker::make('email_verified_at')
                        ->label('Email verified at')
                        ->default(now()),
                ]),
            ]);
    }

    public static function table(Table $table): Table #here we defined the tables (sort of an index for users)
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('role')->sortable(),
                BooleanColumn::make('is_active')->label('Active'),
                TextColumn::make('email_verified_at')->label('Email verified at')->dateTime('M d, Y'),
            ])
            ->filters([])
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

        ];
    }

    public static function getPages(): array #routing handling
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
