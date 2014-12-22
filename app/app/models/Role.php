<?php

class Role extends Model
{
    public function user()
    {
        return $this->belongsTo('User');
    }
}