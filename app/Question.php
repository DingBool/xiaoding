<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
 * Class Question
 * @package App
 */
class Question extends Model
{
	/*
	 * @var array
	 */
	protected $fillable =['title','body','user_id','comments_count','followers_count','answers_count','close_comment','is_hidden','created_at','updated_at'];
	
	/*
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function topics()
	{
		return $this->belongsToMany(Topic::class,'question_topic')->withTimestamps();
	}

	/*
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	/*
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function answer()
	{
		return $this->hasMany(Answer::class);
	}
	
	/*
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function followers()
	{
		return $this->belongsToMany(User::class,'user_question')->withTimestamps();
	}

	/*
	 * @param $query
	 * @return mixed
	 */
	public function scopePublished($query)
	{
		return $query->where('is_hidden','F');
	}

    /*
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany('App\Comment','commentable');
	}
}
