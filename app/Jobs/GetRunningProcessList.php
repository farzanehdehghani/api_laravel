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



class GetRunningProcessList //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 240;//10 min
    public $tries = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Dependencies

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $process = Process::fromShellCommandline('ps aux');
        try {
            $process->mustRun();
            return $process->getOutput();
        } catch (ProcessFailedException $exception) {
            return  $exception->getMessage();

        }


////            $process = new Process('sudo service supervisor restart');
//            $process = new Process('ps aux');
//            $process->run();
//            // executes after the command finishes:wq:q::wqre
//            if (!$process->isSuccessful()) {
//                throw new ProcessFailedException($process);
//            }
//
//            return [$process->getOutput()];


    }

}
