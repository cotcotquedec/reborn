<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use FrenchFrogs\Acl\Acl;
use Models\Business\Article;
use Models\Business\Facebook;
use Models\Business\Twitter;
use Models\Business\User;
use Models\Db\Twitter\Account;
use Schema;
use Models\Db\Article\Process;
use Twitter as TT;
use FrenchFrogs\Laravel\Database\Schema\Blueprint;

class DevController extends Controller
{

    public function layout()
    {

        // Formulaire
        $form = form();
        $form->setLegend('Ajouter une source : ');
        $form->addText('source_url', 'Lien', false)->addValidator('url');
        $form->addButton('charge', 'Chargé')->addAttribute('onclick', 'loadsource(this);');
        $form->addText('source_title', 'Titre');
        $form->addTextarea('source_description', 'Description', false);
        $form->addText('source_media', 'Media', false);
        $form->addBoolean('is_urgent', 'Urgent?');
        $form->addSubmit('Enregistrer');
        return view('dev', compact('form'));
    }


    public function script()
    {
        Process::whereIn('article_process_id', ['ready', 'storyok', 'storytold', 'writing', 'wrote'])->update(['article_process_id' => Article::PROCESS_STATUS_VALIDATED]);


        dd('OK');
        $client = Facebook::getDefaultClient();

        $client->get('/10153399200496881');

        //<div id="fb-root"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.3";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><div class="fb-post" data-href="https://www.facebook.com/frederick.henderson.16/posts/10153399200496881" data-width="500"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/frederick.henderson.16/posts/10153399200496881">Posté par <a href="https://www.facebook.com/frederick.henderson.16">Frederick Henderson</a> sur&nbsp;<a href="https://www.facebook.com/frederick.henderson.16/posts/10153399200496881">lundi 4 avril 2016</a></blockquote></div></div>
        //493908117458252

        //https://www.facebook.com/10153620267278920/?fref=nf


        // envoie de la requete
//        $post = $client->post('/493908117458252/feed', ['message' => 'test share', 'link' => 'https://www.facebook.com/10153620267278920/'], Facebook::getDefault()->getPageToken('493908117458252'));
        $post = $post->getDecodedBody();

        dd($post);

//        dd(\user(null)->getParameters());
        dd(\user()->getParameter('twitter_account_source_id'));
//        TT::getAppRateLimit(['']);







//        Schema::table('genesis_source', function(Blueprint $table) {
//            $table->string('url')->after('name');
//        });


//        Acl::createDatatabaseNavigation('genesis.source',User::INTERFACE_PILIPILI, 'Source', '/genesis/source', User::PERMISSION_GENESIS, 'genesis');
        dd('ok');

//        $client->addScope('https://www.googleapis.com/auth/adsense.readonly');
//        $client->setClientId('1039201687587-e26an22q9c08mobietc7bu5gnr01gobb.apps.googleusercontent.com');
//        $client->setClientSecret('diaa3e-rzzWuvRZ2x5yKzL5x');


        $client = new \Google_Client(
            [
                'oauth2_client_id' => \Config::get('laravel-analytics.clientId'),
                'use_objects' => true,
            ]
        );

        $client->setClassConfig('Google_Cache_File', 'directory', storage_path('app/laravel-analytics-cache'));
        $client->setAccessType('offline');
        $client->setAssertionCredentials(
            new \Google_Auth_AssertionCredentials(
                \Config::get('laravel-analytics.serviceEmail'),
                ['https://www.googleapis.com/auth/adsense.readonly'],
                file_get_contents(\Config::get('laravel-analytics.certificatePath'))
            )
        );

        $service = new \Google_Service_AdSense($client);

        dd($service->accounts->listAccounts());
        dd($service->accounts->listAccounts());
//        $tweet = TT::getTweet('706961637874524161');
//        dd($tweet);

//        \Thujohn\Twitter\Facades\Twitter::class


//        $result = \GA::getMostVisitedPagesForPeriod(Carbon::today()->subDays(1), Carbon::today());
        /** @var \Google_Service_Analytics_GaData $result */
        $result = \GA::performQuery(Carbon::today()->subDays(3), Carbon::today(), 'ga:pageviews', ['dimensions' => 'ga:pagePath', 'sort' => '-ga:pageviews', 'max-results' => 50]);

        foreach($result->getRows() as $row) {

            list($url, $view) = $row;

            // recuperer de l'article
            $article = Process::where('article_url', 'LIKE', '%' . $url . '%')->first();

            if (!empty($article)) {
                // si le score ets meilleur on le surcharge
                if ($article->view_best_ct < $view) {
                    $article->view_best_ct = $view;
                    $article->view_best_at = Carbon::now();
                    $article->save();
                }
            }
        }


//        dd(\GA::setSiteId(config('services.google.gnr_site_id'))->getActiveUsers());
        return 'Are you happy with your script';
    }
}