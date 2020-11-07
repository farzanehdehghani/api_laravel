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
        $userDirectory=auth()->user()->email;
        $process = Process::fromShellCommandline('find "$USER_DIRECTORY" -type d');

        $process->run(null, ['USER_DIRECTORY' => "/opt/myprogram/$userDirectory"]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $fileList= $process->getOutput();
        return $fileList;

    }

    public function getFileList()
    {
        $userDirectory=auth()->user()->email;
        $process = Process::fromShellCommandline('find "$USER_DIRECTORY" -type f');

        $process->run(null, ['USER_DIRECTORY' => "/opt/myprogram/$userDirectory"]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $fileList= $process->getOutput();
        return $fileList;

    /*    //find  /opt/myprogram/$this->userDirectory -type f
        $process = Process::fromShellCommandline("find  /opt/myprogram/$this->userDirectory -type f");
        try {
            $process->mustRun();
            return $processList= $process->getOutput();
        } catch (ProcessFailedException $exception) {
            return $processList=  $exception->getMessage();

        }*/

    }


}
