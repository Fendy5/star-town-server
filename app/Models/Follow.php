<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Follow
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow query()
 * @mixin \Eloquent
 */
class Follow extends Model
{
    use HasFactory;

    protected $table = 'st_follows';

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
