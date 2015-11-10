<?php namespace Models\Business;

use Models\Db;
use Auth;

class User extends \FrenchFrogs\Business\Business
{


    static protected $modelClass = Db\User\User::class;


    static public function loginWithFacebook($email, $name, $picture = false)
    {
        // update user
        $user = Db\User\User::firstOrNew(['email' => $email]);

        if (is_null($user->user_id)) {
            $model = static::create([
                'email' => $email,
                'name' => $name
            ]);
        } else {
            $model = static::get($user->user_id);
        }

        /** @var static $model */
        if ($picture && empty($user->media_id)) {
            $model->addAvatarFromUrl($picture);
        }

        // Authentification
        Auth::loginUsingId($model->getId('bytes'), true);

        return $model;
    }

    /**
     * Add user avatar from an url
     *
     * @param $url
     * @return $this
     * @throws \Exception
     */
    public function addAvatarFromUrl($url)
    {


        try {
            $client = new \GuzzleHttp\Client(['base_uri' => $url, 'timeout' => 2.0]);
            $response = $client->request('GET');

            $mime = $response->getHeader('content-type')[0];
            $content = $response->getBody()->getContents();
            $user = $this->getModel();

            if (empty($user->media_id)) {
                $media = Media::create(['phoenix-' . $this->getId('string'), Media::TYPE_USER_AVATAR, $mime, $content]);
                $user->update(['media_id' => $media->getId('bytes')]);
            } elseif (!empty($content) && md5($content) != Media::get($user->media_id)->getMd5()) {
                $media = Media::get($user->media_id)->update(null, $mime, $content);
                $user->update(['media_id' => $media->getId('bytes')]);
            }

        } catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }

}