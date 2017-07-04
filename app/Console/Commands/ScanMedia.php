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
        collect(\Storage::disk('files')->files(config('filesystems.directories.downloads'), true))->each(function ($file) {

            try {

                // Triu des fichier par rapport a l'extension
                $extension = substr($file, strrpos($file, '.') + 1);
                if (!in_array($extension, ['mp4', 'mkv', 'avi', 'mpg', 'mpeg'])) {
                    return;
                }

                // MEDIA
                $this->info($file);
                $media = new Media($file);

                if (!$media->isVideo()) {
                    $this->info('Le fichier n\'est pas reconu comme une video');
                    return;
                }


                // On verifie que le fichier n'existe pas deja
                $validator = \Validator::make([$media->md5(), $media->getRealpath()], ['unique:medias,file_md5', 'unique:medias,realpath']);
                if ($validator->fails()) {
                    $this->warn('Ce fichier existe deja');
                    return;
                }

                $db = $media->db();
                $db->isNew() && $media->search();

            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        });
    }
}
