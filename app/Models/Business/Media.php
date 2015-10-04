<?php namespace Models\Business;

use Models\Db;


class Media
{

    const TYPE_USER_AVATAR = 'user_avatar';


    /**
     * Primary key of the single row object
     *
     * @var
     */
    protected $id;

    /**
     * Create the media in database
     *
     * @param $name
     * @param $content
     */
    public static function create($name, $type, $mime, $content)
    {

        $media = Db\Media\Media::create(['media_type_id' => $type, 'hash_md5' => md5($content)]);
        $media->attachment()->create(['name' => $name, 'content' => $content, 'size' => strlen($content), 'mime' => $mime]);

        return static::get($media->media_id);
    }


    /**
     * update file
     *
     * @param $name
     * @param $mime
     * @param $content
     * @return $this
     */
    public function update($name, $mime, $content)
    {
        $media = Db\Media\Media::findOrFail($this->getId());
        $media->hash_md5 = md5($content);
        $media->save();

        $attachment = $media->attachment()->findOrFail($this->getId());
        $attachment->name = $name;
        $attachment->content = $content;
        $attachment->size = strlen($content);
        $attachment->mime = $mime;
        $attachment->save();

        return $this;
    }


    /**
     * Constructor
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;

    }

    public function getMd5()
    {
        return Db\Media\Media::findOrFail($this->getId())->first()->hash_md5;
    }


    /**
     * Static constructor
     *
     * @param $id
     * @return \Models\Business\Media
     */
    static public function get($id)
    {
        return new Media($id);
    }


    static public function show($id)
    {



    }

    public function getId()
    {
        return $this->id;
    }

}