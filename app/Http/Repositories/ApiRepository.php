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
    /**
     * @return BaseAnswer
     */
    function baseAnswer()
    {
        return BaseAnswer::getInstance();
    }

    public function createFile($fileName){

        $fileName=sanitize($fileName);

        $process = Process::fromShellCommandline('touch "$FILENAME"');

        $process->run(null, ['FILENAME' => "$fileName.txt"]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $fileCreated= $process->getOutput();
        return $fileCreated;

    }

}
