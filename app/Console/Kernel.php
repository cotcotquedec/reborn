<?php

namespace App\Console;

use App\Console\Commands;
use FrenchFrogs\Scheduler\Console\SchedulerKernel;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use FrenchFrogs\Models\Db;

class Kernel extends ConsoleKernel
{
    use SchedulerKernel;

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\Permission::class,
        Commands\PermissionRemove::class,
        Commands\TwitterAccountLookup::class,
        Commands\TwitterVerify::class,
        //\FrenchFrogs\Scheduler\Console\Commands\SchedulerTable::class,
        Commands\Minify::class,
        Commands\TwitterFriendshipsCreateLimitationReset::class,
        Commands\TwitterFollow::class,
        Commands\TwitterUnfollow::class,
        Commands\Upgrade::class,
        Commands\AnalyticsRealtime::class,
        Commands\TwitterPurgeLog::class,


        Commands\FacebookPageFeed::class,
        Commands\FacebookPageFeedMetrics::class,
        Commands\TwitterSchedule::class,
        Commands\GenesisCrawl::class,


        // Mail
        Commands\MailAnalytics::class,


        //TMP
        //Commands\TmpArticleThumbnail::class,
    ];

    
    public function handle($input, $output = null)
    {
        return $this->handleSchedule($input, $output);
    }


    public function terminate($input, $status)
    {
        $this->terminateSchedule($input, $status);
        parent::terminate($input, $status); // TODO: Change the autogenerated stub
    }
}
