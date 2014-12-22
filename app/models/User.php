<?php

class User extends Model
{
    public function role()
    {
        return $this->hasOne('Role', 'id', 'role_id');
    }
}