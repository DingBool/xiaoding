<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Messages
 * @package App
 */
class Messages extends Model
{
    /**
     * @var string
     * @var array
     */
    protected $table = 'messages';
    /**
     * @var array
     */
    protected $fillable = ['form_user_id','to_user_id','body','dialog_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class,'form_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }

    /**
     * @return array
     */
    public function markAsRead()
    {
        if(is_null($this->read_at))
        {
            $this->forceFill(['has_read' => 'T' ,'read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * @param array $models
     * @return MessageController
     */
    public function newCollection(array $models = [])
    {
        return new MessageController($models);
    }

    /**
     * @return bool
     */
    public function read()
    {
        return $this->has_read === 'T';
    }

    /**
     * @return bool
     */
    public function unread()
    {
        return $this->has_read === 'F';
    }

    /**
     * @return bool
     */
    public function shouldAppUnreadClass()
    {
        if(user()->id === $this->form_user_id)
        {
            return false;
        }
        return $this->unread();
    }
}
