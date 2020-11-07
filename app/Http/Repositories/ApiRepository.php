<?php


namespace App\Http\Repositories;


use App\Helpers\BaseAnswer;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ApiRepository
{

    private $request;
    private $userDirectory;

    /**
     * ApiRepository constructor.
     */
    public function __construct()
    {
        $this->setUserDirectory();
        dd($this->request->user);

    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    public function setUserDirectory($user)
    {
        $this->userDirectory = $this->request->user;
        return $this;
    }

    public function createFile($fileName){

        $fileName=sanitize($fileName);

        $process = Process::fromShellCommandline('touch "$FILENAME"');

        $process->run(null, ['FILENAME' => "/opt/myprogram/$this->userDirectory/$fileName.txt"]);

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
        $process = Process::fromShellCommandline('find "$USER_DIRECTORY" -type d');

        $process->run(null, ['USER_DIRECTORY' => "/opt/myprogram/$this->userDirectory"]);

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

        $process->run(null, ['USER_DIRECTORY' => "/opt/myprogram/$this->userDirectory"]);

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
