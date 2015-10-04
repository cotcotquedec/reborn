<?php namespace Models\Db\Media;


use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{

    protected $table = 'media_attachment';
    protected $primaryKey = 'media_id';
    public $incrementing = false;
    protected $fillable = ['name', 'content', 'size', 'mime'];
}