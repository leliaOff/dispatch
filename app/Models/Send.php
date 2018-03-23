<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Send extends Model
{
    protected $fillable = ['user_id', 'template_id', 'channel_id', 'contact', 'data', 'text'];

    /* Пользователь, который произвел отправку */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /* Используемый шаблон */
    public function template()
    {
        return $this->belongsTo('App\Models\Template');
    }

    /* Используемый канал */
    public function channel()
    {
        return $this->belongsTo('App\Models\Channel');
    }

    /* История состояний сообщений */
    public function statuses()
    {
        return $this->hasMany('App\Models\SendsStatus');
    }

}
