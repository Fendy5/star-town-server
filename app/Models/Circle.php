<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Circle
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Circle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Circle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Circle query()
 * @mixin \Eloquent
 */
class Circle extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'st_circles';

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class,'cc_id');
    }

    public function fl_users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getCircleList($keywords='*')
    {
        return $this->where('name', 'like', '%'.$keywords.'%')->get();
    }
}
