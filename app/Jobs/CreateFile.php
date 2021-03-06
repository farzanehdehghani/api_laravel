<?php

namespace App\Jobs;
use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\VarDumper\VarDumper;
use Illuminate\Support\Facades\DB;
use Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;



class CreateFile //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->fileName= sanitize("$fileName");

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileName=sanitize($request->file_name);

        $process = Process::fromShellCommandline('touch "$FILENAME"');

        $process->run(null, ['FILENAME' => "$fileName.txt"]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $fileCreated= $process->getOutput();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

//        echo $process->getOutput();
         return true;



    }

}
