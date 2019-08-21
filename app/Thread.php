<?php

namespace App;

use App\Filters\ThreadFilters;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

/**
 * @method static create(array $array)
 */
class Thread extends Model
{
    use RecordsActivity;
    protected $guarded = [];
    //   protected $fillable = ['title', 'channel_id', 'user_id', 'body'];
    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    /**
     * helper to link to /threads/{id}
     * @return string of path to thread
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @param  $reply
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function getReplyCount()
    {
        $this->replies()->count();
    }
}
