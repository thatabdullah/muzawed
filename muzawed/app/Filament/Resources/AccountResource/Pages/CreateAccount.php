<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // creates the account
        $account = Account::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'logo' => $data['logo'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        // creates the admin user from the account resource in admin page
        $admin = User::create([
            'name' => $data['admin_name'],
            'email' => $data['admin_email'],
            'password' => Hash::make($data['admin_password']),
            'role' => 'admin',
            'account_id' => $account->id,
        ]);

        // creates the members user from the account resource in admin page
        if (!empty($data['members'])) {
            foreach ($data['members'] as $member) {
                User::create([
                    'name' => $member['name'],
                    'email' => $member['email'],
                    'password' => Hash::make($member['password']),
                    'role' => 'member',
                    'account_id' => $account->id,
                ]);
            }
        }

        return [];
    }

}
