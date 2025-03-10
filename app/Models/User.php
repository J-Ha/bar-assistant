<?php

declare(strict_types=1);

namespace Kami\Cocktail\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('realUsers', function (Builder $builder) {
            $builder->where('id', '>', 1);
        });
    }

    /**
     * @return HasMany<UserIngredient>
     */
    public function shelfIngredients(): HasMany
    {
        return $this->hasMany(UserIngredient::class);
    }

    /**
     * @return HasMany<CocktailFavorite>
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(CocktailFavorite::class);
    }

    /**
     * @return HasMany<UserShoppingList>
     */
    public function shoppingList(): HasMany
    {
        return $this->hasMany(UserShoppingList::class);
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    public function isUser(): bool
    {
        return !$this->isAdmin();
    }
}
