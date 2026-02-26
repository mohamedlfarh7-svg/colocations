<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property numeric $price
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Expense> $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ColocationImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Invitation> $invitations
 * @property-read int|null $invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colocation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Colocation extends Model
{
    protected $fillable = ['title', 'description', 'price', 'address'];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'memberships')
                    ->withPivot('role', 'left_at')
                    ->withTimestamps();
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ColocationImage::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}