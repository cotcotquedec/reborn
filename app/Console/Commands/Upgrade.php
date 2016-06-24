<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Upgrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade application';

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

        $is_production = app()->environment() == 'production';

        if ($is_production) {
            $confirm =  $this->confirm('Vous êtes en PRODUCTION , livrer (y/N)?', false);
        } else {
            $confirm = true;
        }


        if ($confirm) {

            // on tente l'execution du script
            try {

                //git pull
                $process = new Process(sprintf('cd "%s" &&  git pull', app()->basePath()));
                $process->run();
                if (!$process->isSuccessful()) {throw new \RuntimeException($process->getErrorOutput());}
                $this->info(trim($process->getOutput()));
                if ($error = $process->getErrorOutput()) {
                    $this->error($error);
                }

                // update de composer
                if ($this->confirm('Voulez vous updater composer? (y/N)?', false)) {
                    $process = new Process(sprintf('cd "%s" &&  composer update', app()->basePath()));
                    $process->run();
                    if (!$process->isSuccessful()) {
                        throw new \RuntimeException($process->getErrorOutput());
                    }
                    $this->info(trim($process->getOutput()));
                    if ($error = $process->getErrorOutput()) {
                        $this->error($error);
                    }
                }

                // Migration
                $this->call('migrate');

                // Reload apache
                /*
                $process = new Process('sudo /etc/init.d/apache2 reload');
                $process->run();
                if (!$process->isSuccessful()) {
                    throw new \RuntimeException($process->getErrorOutput());
                }
                $this->info(trim($process->getOutput()));
                if ($error = $process->getErrorOutput()) {
                    $this->error($error);
                }
                */

                $this->call('cache:clear');
                $this->call('minify');
                $this->call('queue:restart');

            } catch(\Exception $e) {$this->error($e->getMessage());}
        }
    }
}
