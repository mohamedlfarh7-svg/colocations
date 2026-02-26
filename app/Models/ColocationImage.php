<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $colocation_id
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColocationImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColocationImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColocationImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColocationImage whereColocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColocationImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColocationImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColocationImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColocationImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ColocationImage extends Model
{
    //
}
