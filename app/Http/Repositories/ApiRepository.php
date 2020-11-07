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

    /**
     * @param $user
     * @return $this
     */
    public function setUserDirectory($user)
    {
        //user already validated in middleware
        $this->userDirectory = $user;
        return $this;
    }

    /**
     * @param $fileName
     * @return string
     */
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

    /**
     * @return string
     */
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

    /**
     * @return string
     */
    public function getDirectoryList()
    {
        $process = Process::fromShellCommandline('find "$USER_DIRECTORY" -type d -printf "%f\n"');

        $process->run(null, ['USER_DIRECTORY' => "/opt/myprogram/$this->userDirectory"]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $fileList= $process->getOutput();
        return convertBashOutputToArray($fileList);

    }

    /**
     * @return string
     */
    public function getFileList()
    {
        $userDirectory=auth()->user()->email;
        $process = Process::fromShellCommandline('find "$USER_DIRECTORY" -type f -printf "%f\n"');

        $process->run(null, ['USER_DIRECTORY' => "/opt/myprogram/$this->userDirectory"]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $fileList= $process->getOutput();
        return convertBashOutputToArray($fileList);


    }


}
