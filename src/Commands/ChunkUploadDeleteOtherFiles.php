<?php

namespace YunusEmreBaloglu\ChunkUpload\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ChunkUploadDeleteOtherFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chunk-upload:delete_files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes old files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $disk = Storage::disk(config('chunk-upload.disk'));
        foreach ($disk->files() as $file) {
            if (Carbon::now()->diffInMinutes(Carbon::createFromTimestamp($disk->lastModified($file))) > config('chunk-upload.delete_minute')) {
                $disk->delete($file);
            }
        }
    }
}
