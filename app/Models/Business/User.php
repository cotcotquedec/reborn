<?php namespace Models\Business;

use Carbon\Carbon;
use Models\Db;
use Auth;

class User extends \FrenchFrogs\Models\Business\User
{

    // INTERFACE
    const INTERFACE_PILIPILI = 'default';

    // PERMISSION GROUP
    const PERMISSION_GROUP_SOCIAL = 'twitter';
    const PERMISSION_TWITTER = 'twitter';
    const PERMISSION_TWITTER_INTERNAL = 'twitter_internal';
    const PERMISSION_TWITTER_FOLLOW = 'twitter_follow';
    const PERMISSION_FACEBOOK = 'facebook';
    const PERMISSION_FACEBOOK_INTERNAL = 'facebook_internal';

    const PERMISSION_GROUP_PILIPILI = 'pilipili';
    const PERMISSION_USER = 'user';

    const PERMISSION_GROUP_ADMIN = 'admin';
    const PERMISSION_ADMIN = 'admin';
    const PERMISSION_SCHEDULE = 'schedule';

    const PERMISSION_GROUP_ARTICLE = 'article';
    const PERMISSION_ARTICLE = 'article';
    const PERMISSION_ARTICLE_CONTRIBUTOR = 'article_contributor';
    const PERMISSION_ARTICLE_MANAGER = 'article_manager';

    const PERMISSION_GROUP_GENESIS = 'genesis';
    const PERMISSION_GENESIS = 'genesis';


    const PERMISSION_GROUP_DISTRIBUTOR = 'distributor';
    const PERMISSION_DISTRIBUTOR = 'distributor';

    static protected $modelClass = Db\User\User::class;


    /**
     * Loggin user with google
     *
     * @param $email
     * @param $name
     * @param bool|false $picture
     * @param bool|false $is_phoenix
     * @return \Models\Business\Business
     */
    static public function loginWithGoogle($email, $name ,$picture = false)
    {
        // update user
        $user = Db\User\User::firstOrNew(['email' => $email, 'user_interface_id' => static::INTERFACE_PILIPILI]);

        if (is_null($user->user_id)) {
            $model = static::create([
                'email' => $email,
                'user_interface_id' => static::INTERFACE_PILIPILI,
                'name' => $name
            ]);
        } else {
            $model = static::get($user->user_id);
        }

        /**@var static $model*/

        //maj information de connexion
        $user = $model->getModel();
        $user->loggedin_at = Carbon::now();
        $user->save();

        //media
        if ($picture) {
            $model->addAvatarFromGoogleUrl($picture);
        }

        // Authentification
        Auth::loginUsingId($user->user_id, true);

        return $model;
    }

    /**
     * Create avatar from google avatar url
     *
     * @param $url
     * @return $this
     * @throws \Exception
     */
    public function addAvatarFromGoogleUrl($url)
    {

        try {
            // recupéraiton du contenu de l'image
            $client = new \GuzzleHttp\Client(['base_uri' => $url, 'timeout' => 2.0]);
            $response = $client->request('GET');
            $mime = $response->getHeader('content-type')[0];
            $content = $response->getBody()->getContents();

            // sauvegarde de l'image
            $model = $this->getModel();
            if (empty($model->media_id)) {
                $media = Media::create(['pilipili-' . $this->getId('string'), Media::TYPE_PILIPILI_AVATAR, $mime, $content]);
                $this->getModel()->update(['media_id' => $media->getId('bytes')]);
            } elseif (!empty($content) && md5($content) != Media::get($model->media_id)->getMd5()) {
                $media = Media::get($model->media_id)->update(null, $mime, $content);
                $this->getModel()->update(['media_id' => $media->getId('bytes')]);
            }

        } catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }

}
