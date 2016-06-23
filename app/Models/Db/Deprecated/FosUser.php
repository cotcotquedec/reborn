<?php namespace Models\Db\Deprecated;


use FrenchFrogs\Laravel\Database\Eloquent\Model;

class FosUser extends Model
{
    protected $table = 'fos_user';
    public $timestamps = false;
}