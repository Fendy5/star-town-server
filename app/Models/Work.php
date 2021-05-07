<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function dd;

/**
 * App\Models\Work
 *
 * @property int $id
 * @property int $user_id 用户ID，外键
 * @property string $title 标题
 * @property string $desc 简介
 * @property string $type 作品类型(1-文字，2-小说，3-时评，4-漫画，5-写真，6-手绘)
 * @property string $cover 封面
 * @property string $content 作品内容
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Work newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work query()
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereUserId($value)
 * @mixin \Eloquent
 */
class Work extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $guarded = [];

    protected $table = 'st_works';

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addWork($data)
    {
        return $this->create($data);
    }

    public function getWorkList(int $type=6,Array $page=['order_field' => 'id', 'order' => 'desc', 'pageNo' => 1, 'pageSize' => 8])
    {
        return $this->where('type','<=',$type)->orderBy($page['order_field'],$page['order'])->paginate($page['pageSize'],['*'],'page',$page['pageNo']);
    }

    // 根据喜欢的数量排序作品
    public function getWorkByLike($type=1,$order_field='likes',$amount=3)
    {
        $types = [[1, 6], [1, 3], [4, 6]];
        $type = $types[$type];
        return $this->whereBetween('type', $type)->withCount($order_field)->orderByDesc($order_field.'_count')->take($amount)->get();
    }

    // 根据类型搜索作品
    public function getWorkByType($type=0, $page=['order_field' => 'id', 'order' => 'desc', 'pageNo' => 1, 'pageSize' => 4], $ccId=null,$keywords='*'): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $types = [[1, 2, 3, 4, 5, 6], [1], [2], [3], [4], [5], [6],[1,2,3],[4,5,6]]; // 7-文字星球，8-艺术星球
        if ($circle = Circle::find($ccId)) {
            $users = $circle->users;
            return $this->whereIn('type',$types[$type])->whereIn('user_id',[$users[0]['id'],$users[1]['id']])->where('title','like','%'.$keywords.'%')->orderBy($page['order_field'],$page['order'])->paginate($page['pageSize'],['*'],'page',$page['pageNo']);
        } else {
            return $this->whereIn('type',$types[$type])->where('title','like','%'.$keywords.'%')->orderBy($page['order_field'],$page['order'])->paginate($page['pageSize'],['*'],'page',$page['pageNo']);
        }
    }
}
