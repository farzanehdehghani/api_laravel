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
    public $timeout = 240;//10 min
    public $tries = 2;
    public $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName)
    {

        $this->fileName= $fileName;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if (!file_exists("/opt/myprogram/".$this->fileName.'.txt')) {

            $process = new Process('vim'.$this->fileName.'.txt');
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            return true;

        }else return false;



    }

}
