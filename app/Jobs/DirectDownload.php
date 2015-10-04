<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class DirectDownload extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $link;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // Temporary download file name
        $basename = basename($this->link);
        $tmp = 'tmp/' . $basename . '.tmp';

        // if file exist, we prepend _
        while(Storage::exists($tmp)) {
            $tmp = '_' . $tmp;
        }

        // stream download
        $stream = fopen( $this->link, 'r');
        Storage::writeStream($tmp, $stream);

        // if final file already exist with the same name, we prepend filename with _
        while(Storage::exists($basename)) {
            $basename = '_' .  $basename;
        }

        // move file to the final directory
        Storage::move($tmp, $basename);
    }
}
