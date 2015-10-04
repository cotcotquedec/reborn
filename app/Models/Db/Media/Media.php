<?php namespace Models\Db\Media;


use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    protected $table = 'media';
    protected $primaryKey = 'media_id';
    protected $fillable = ['media_type_id', 'hash_md5'];

    public function attachment()
    {
        return $this->hasOne(\Models\Db\Media\Attachment::class, 'media_id', 'media_id');
    }

}