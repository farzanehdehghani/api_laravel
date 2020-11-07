<?php


namespace App\Http\Repositories;


use App\Helpers\BaseAnswer;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ApiRepository
{

    private $request;

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    public function createFile($fileName){

        $fileName=sanitize($fileName);

        $process = Process::fromShellCommandline('touch "$FILENAME"');

        $process->run(null, ['FILENAME' => "/opt/myprogram/$fileName.txt"]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $fileCreated= $process->getOutput();
        return $fileCreated;

    }

    public function getRunningProcessesList()
    {
        $process = Process::fromShellCommandline('ps aux');
        try {
            $process->mustRun();
            return $processList= $process->getOutput();
        } catch (ProcessFailedException $exception) {
            return $processList=  $exception->getMessage();

        }

    }

    public function getDirectoryList()
    {
        $process = Process::fromShellCommandline('ls /opt/myprogram');
        try {
            $process->mustRun();
            return $processList= $process->getOutput();
        } catch (ProcessFailedException $exception) {
            return $processList=  $exception->getMessage();

        }

    }

    public function createUserDirectory(){

        $userName=auth()->user()->email;
        $process = new Process(['mkdir', "/opt/myprogram/$userName"]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
         return $process->getOutput();

    }

}
