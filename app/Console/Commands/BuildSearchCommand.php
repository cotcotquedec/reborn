<?php

namespace App\Console\Commands;

use App\Models\Db\Medias;
use Illuminate\Console\Command;

class BuildSearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ajoute tout les Medias a la recherche';

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
        Medias::get()->searchable();
    }
}
