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



class CreateDirectory //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 240;//10 min
    public $tries = 2;
    public $directoryName;
    public $userDirectory;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($directoryName)
    {

        $this->directoryName= sanitize($directoryName);
        $this->userDirectory=auth()->user()->email;


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

           //if ( !file_exists( "/opt/myprogram/".$this->directoryName ) ) {
            $process = new Process(['mkdir', "/opt/myprogram/$this->userDirectory/$this->directoryName"]);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            return $process->getOutput();
           //return true;
           // }else return false;


    }

}
