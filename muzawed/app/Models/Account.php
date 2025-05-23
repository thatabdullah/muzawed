<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'description_en', 'description_ar'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function admin(): HasMany
    {
        return $this->hasMany(User::class)->where('role', 'admin');
    }
}
