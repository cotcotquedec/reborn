<?php

namespace App\Console\Commands;

use App\Models\Media;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pour faire des test';

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

        $movie = query('elfinder_path as p', [
            'p.path_id as path_id',
            'content',
            'reference_id',
            'insert'
        ])
            ->join('elfinder_path_reference as r', 'p.path_id', 'r.path_id')
            ->where('reference_table', 'themoviedb_movie')
            ->where('reference_column', 'id')
            ->limit(3)
            ->get();


        $movie->each(function ($row) {

            if (!\Storage::disk('files')->exists($row->content)) {
                return;
            }

            $files = \Storage::disk('files')->files($row->content, true);


            collect($files)->each(function ($file) use ($row) {

                $this->info($file);

                $media = new Media($file);

                if (!$media->isVideo()) {
                    $this->info('Le fichier n\'est pas reconu comme une video');
                    return;
                }

                // On verifie que le fichier n'existe pas deja
                $validator = \Validator::make([$media->md5()], ['unique:medias,file_md5']);
                if ($validator->fails()) {
                    $this->warn('Ce fichier existe deja');
                    return;
                }

                transaction(function () use ($media, $row) {

                    $db = $media->db();

                    // STOCKAGE
                    $movie = $row->reference_id;
                    $infos = \Tmdb::getMoviesApi()->getMovie($movie);

                    // Synchro avec la base
                    $db->search_info = [$movie => ['movie' => $infos]];
                    $db->type_rid = \Ref::MEDIA_TYPE_MOVIE;
                    $db->status_rid = \Ref::MEDIA_STATUS_SCAN;
                    $db->save();

                    $media = Media::fromDb($db);

                    $db->update([
                        'data' => $db->search_info[$movie],
                        'stored_at' => $row->insert,
                        'status_rid' => \Ref::MEDIA_STATUS_STORED
                    ]);

                    \DB::table('elfinder_path_reference')
                        ->where('path_id', $row->path_id)
                        ->update([
                            'reference_column' => 'done'
                        ]);
                });
            });
        });


        $this->info('This is a test');
    }
}