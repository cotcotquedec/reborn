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

        // tmp file name;
        $tmp = $dest = basename($this->link);
        $tmp .= '.tmp';

        // if file exist, we prepend _
        while(Storage::disk('files')->exists('tmp/' . $tmp)) {
            $tmp = '_' . $tmp;
        }

        $tmp = 'tmp/' . $tmp;

        // stream download
        $stream = fopen( $this->link, 'r');
        Storage::disk('files')->writeStream($tmp, $stream);

        // if final file already exist with the same name, we prepend filename with _
        while(Storage::disk('files')->exists('downloads/' . $dest)) {
            $dest = '_' .  $dest;
        }
        $dest = 'downloads/' . $dest;

        // move file to the final directory
        Storage::disk('files')->move($tmp, $dest);
    }
}
