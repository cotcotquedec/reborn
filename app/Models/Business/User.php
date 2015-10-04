<?php namespace Models\Business;

use Models\Db;
use Auth;

class User
{

    /**
     * ID of user
     *
     * @var
     */
    protected $id;

    /**
     * Constructor
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }


    /**
     * factory
     *
     * @param $id
     * @return \Models\Business\User
     */
    static public function get($id)
    {
        return new User($id);
    }

    /**
     * Getter for ID
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * return true id user exist
     *
     * @param $id
     * @return bool
     */
    static public function exists($id)
    {
        try {
            Db\User\User::findOrFail($id);
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    static public function loginWithFacebook($email, $name, $picture = false)
    {
        // update user
        $user = Db\User\User::firstOrNew(['email' => $email]);
        $user->name = $name;
        $user->loggedin_at = \DB::raw('NOW()');
        $user->save();




        $model = static::get($user->user_id);
        if ($picture && empty($user->media_id)) {
            $model->addAvatarFromUrl($picture);
        }

        // Authentification
        Auth::loginUsingId($user->user_id, true);

        return $model;
    }

    public function addAvatarFromUrl($url)
    {

        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
//            throw new \InvalidArgumentException( $url . ' n\'est pas une url valide');
        }

        try {
            $client = new \GuzzleHttp\Client(['base_uri' => $url, 'timeout' => 2.0]);
            $response = $client->request('GET');

            $type = $response->getHeader('content-type')[0];
            $content = $response->getBody()->getContents();
            $user = Db\User\User::findOrFail($this->getId())->first();

            if (empty($user->media_id)){
                $media = Media::create('avatar-' . $this->getid(), Media::TYPE_USER_AVATAR, $type, $content);
                $user->media_id = $media->getId();
                $user->save();
            } elseif (!empty($content) && md5($content) != Media::get($user->media_id)->getMd5()) {
                $media = Media::get($user->media_id)->update('avatar-' . $this->getId(), $type, $content);
                $user->media_id = $media->getId();
                $user->save();
            }

        }catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }

}