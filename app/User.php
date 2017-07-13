<?php

namespace App;

use App\Mailer\UserMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;
    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token','settimgs','api_token','settings'
    ];

    /*
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'setting' => 'array'
    ];


    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        (new UserMailer()) ->passwordReset($this->email,$token);
    }


    /**
     * @param Model $model
     * @return bool
     */
    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answer()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows()
    {
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }


    /**
     * @param $question
     * @return array
     */
    public function followsThis($question)
    {
        return $this->follows()->toggle($question);
    }


    /**
     * @param $question
     * @return bool
     */
    public function followed($question)
    {
        return !!$this->follows()->where('question_id',$question)->count();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followeds()
    {
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }


    /**
     * @param $user
     * @return array
     */
    public function followThisUser($user)
    {
        return $this->followeds()->toggle($user);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();
    }


    /**
     * @param $answer
     * @return array
     */
    public function voteFoi($answer)
    {
        return $this->votes()->toggle($answer);
    }


    /**
     * @param $answer
     * @return bool
     */
    public function hasVotedFor($answer)
    {
        return !!$this->votes()->where('answer_id',$answer)->count();
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function message()
    {
        return $this->hasMany(Messages::class,'to_user_id');
    }

//    /**
//     * @return Settings
//     */
//    public function settings()
//    {
//        return new Settings($this);
//    }
}
