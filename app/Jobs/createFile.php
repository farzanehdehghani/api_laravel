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
        $this->fileName= sanitize("$fileName");

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

//        $process = new Process(['/path/command', '--option', 'argument', 'etc.']);
//        $process = new Process(['/path/to/php', '--define', 'memory_limit=1024M', '/path/to/script.php']);

//        if (!file_exists("/opt/myprogram/"."$this->fileName.txt")) {
            $process = new Process('touch {{ path }}{{ file_name }}');
            $process->run(null, [
//                'path' => getenv('DEFAULT_PATH'),
                'path' => '/opt/myprogram/',
                'file_name' => $this->fileName . '.txt',
            ]);

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

             return $process->getOutput();
//            return true;

//        }else return false;


  /*      if (!file_exists("/opt/myprogram/"."$this->fileName.txt")) {

            $process = new Process('touch'."$this->fileName.txt");
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

//            return $process->getOutput();

            return true;

        }else return false;*/



    }

}
