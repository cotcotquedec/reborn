<?php

namespace App\Console\Commands;

use App\Models\Db\Downloads;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Download extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Télécharge les fichiers';

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

        while ($download = Downloads::where('status_rid', \Ref::DOWNLOADS_STATUS_CREATED)->first()) {
//        while ($download = Downloads::first()) {

            // ON commence le process
            $download->update(['status_rid' => \Ref::DOWNLOADS_STATUS_INPROGRESS]);

            $this->info('Telechargement de ' . $download->url);

            try {

                // FICHIER TEMPORAIRE
                $tmp = config('filesystems.directories.downloads') . DIRECTORY_SEPARATOR . basename($download->url) . '.' . uuid($download->getKey())->hex;
                if (\Storage::disk('files')->exists($tmp)) {
                    throw new \Exception('Le fichier existe déjà : ' . $tmp);
                }

                // DOWNLOAD
                $stream = fopen($download->url, 'r');
                \Storage::disk('files')->writeStream($tmp, $stream);

                // DESTINATION
                $destination = basename($download->url);
                while (\Storage::disk('files')->exists(config('filesystems.directories.downloads') . DIRECTORY_SEPARATOR . $destination)) {
                    $destination = '_' . $destination;
                }
                $destination = config('filesystems.directories.downloads') . DIRECTORY_SEPARATOR . $destination;

                //DEPLACEMENT
                \Storage::disk('files')->move($tmp, $destination);

                // change file permission
                chmod(\Storage::disk('files')->getAdapter()->applyPathPrefix($destination), 0775);

                //MAJ
                $download->update([
                    'status_rid' => \Ref::DOWNLOADS_STATUS_COMPLETED,
                    'completetd_at' => Carbon::now()
                ]);

            } catch (\Exception $e) {
                $download->update([
                    'status_rid' => \Ref::DOWNLOADS_STATUS_ERROR,
                    'errors' => $e->getMessage()
                ]);

                $this->error($e->getMessage());
            }
        }
    }
}
