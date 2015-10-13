<?php namespace Models\Business;

use Models\Db;
use Auth;

class User extends Business
{


    static protected $modelClass = Db\User\User::class;


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