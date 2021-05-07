<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Comment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table='st_comments';

    protected $dateFormat = 'Y-m-d H:i:s';

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class,'comment_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function to_user()
    {
        return $this->belongsTo(User::class,'to_id','id');
    }

    //    public function parent()
//    {
//        return $this->belongsTo(Comment::class);
//    }
//
//    public function parents()
//    {
//        return $this->hasMany(Comment::class,'parent_id','id');
//    }

    /**
     * Prepare a date for array / JSON serialization.
     * @param  DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
