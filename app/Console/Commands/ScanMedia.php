<?php

namespace App\Console\Commands;

use App\Models\Media;
use Illuminate\Console\Command;

class ScanMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan les médias qui sont présent dans les téléchargement';

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

        // PARCOURS DE TOUS LES FICHIERS
        collect(\Storage::disk('files')->files(config('filesystems.directories.torrents'), true))->each(function ($file) {

            // MEDIA
            $this->info($file);
            $media = new Media($file);

            if (!$media->isVideo()) {
                return;
            }

            $db = $media->db();

            $db->isNew() && $media->search();
        });
    }
}
