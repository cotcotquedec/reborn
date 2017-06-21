<?php

namespace App\Console\Commands;

use App\Models\Db\Medias;
use Illuminate\Console\Command;

class CleanNonExistsFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:clean {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suppression des fichier qui n\'existe pas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if ($this->option('all')) {
            $medias = Medias::pluck('realpath', 'uuid');
        } else {
            $medias = Medias::where('status_rid', \Ref::MEDIA_STATUS_NEW)->pluck('realpath', 'uuid');
        }

        $medias->each(function ($file, $uuid) {

            if (!file_exists($file)) {
                Medias::find($uuid)->forceDelete();
                $this->info('Suppression : ' . $file);
            }

        });
    }
}
