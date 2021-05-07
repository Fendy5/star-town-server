<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Like
 *
 * @property int $id
 * @property int $user_id 用户Id，外键
 * @property int $work_id 作品Id，外键
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Like $user
 * @method static \Illuminate\Database\Eloquent\Builder|Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Like newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Like query()
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereWorkId($value)
 * @mixin \Eloquent
 */
class Like extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'st_likes';

    public function user()
    {
        return $this->belongsTo(Like::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
