<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as Guzzle;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->slack();
    }



    public function slack()
    {
        $this->mergeConfigFrom(app_path() . '/../vendor/maknz/slack/src/config/config.php', 'slack');

        $this->app['maknz.slack'] = $this->app->share(function($app)
        {
            return new \Models\Slack(
                $app['config']->get('slack.endpoint'),
                [
                    'channel' => $app['config']->get('slack.channel'),
                    'username' => $app['config']->get('slack.username'),
                    'icon' => $app['config']->get('slack.icon'),
                    'link_names' => $app['config']->get('slack.link_names'),
                    'unfurl_links' => $app['config']->get('slack.unfurl_links'),
                    'unfurl_media' => $app['config']->get('slack.unfurl_media'),
                    'allow_markdown' => $app['config']->get('slack.allow_markdown'),
                    'markdown_in_attachments' => $app['config']->get('slack.markdown_in_attachments')
                ],
                new Guzzle
            );
        });

        $this->app->bind('Maknz\Slack\Client', 'maknz.slack');
    }


    public function google()
    {

/*
        $this->app->singleton('GoogleClient', function($app)
        {
            $client = new \Google_Client(
                [
                    'oauth2_client_id' => config()->get('laravel-analytics.clientId'),
                    'use_objects' => true,
                ]
            );

            $client->setClassConfig('Google_Cache_File', 'directory', storage_path('app/laravel-analytics-cache'));

            $client->setAccessType('offline');

            $client->setAssertionCredentials(
                new \Google_Auth_AssertionCredentials(
                    config()->get('laravel-analytics.serviceEmail'),
                    ['https://www.googleapis.com/auth/analytics.readonly'],
                    file_get_contents(config()->get('laravel-analytics.certificatePath'))
                )
            );

            return $client;
        });
*/
    }
}
