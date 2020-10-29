<?php

namespace App\Http\Controllers;

use App\Helpers\BaseAnswer;
use App\Http\Repositories\ApiRepository;
use App\Jobs\CreateDirectory;
use App\Jobs\CreateFile;
use App\Jobs\GetRunningProcessList;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ApiController extends Controller
{

    private $apiRepository;

    /**
     * ApiController constructor.
     * @param ApiRepository $apiRepository
     */
    public function __construct(ApiRepository $apiRepository)
    {
        $this->apiRepository= $apiRepository;
    }
    /**
     * @return BaseAnswer
     */
    function baseAnswer()
    {
        return BaseAnswer::getInstance();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRunningProcessesList(Request $request){

        $process = Process::fromShellCommandline('ps aux');
        try {
            $process->mustRun();
            $processList= $process->getOutput();
        } catch (ProcessFailedException $exception) {
            $processList=  $exception->getMessage();

        }

//        $process->start();
//
//        foreach ($process as $type => $data) {
//            if ($process::OUT === $type) {
//                echo "\nRead from stdout: ".$data;
//            } else { // $process::ERR === $type
//                echo "\nRead from stderr: ".$data;
//            }
//        }

//        echo "--------------------";

//        $process->start();
//        $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
//        foreach ($iterator as $data) {
//            echo $data."\n";
//        }

        return ;

//        $processList=GetRunningProcessList::dispatch();

            echo -e $processList;
        return response()->json(
            $this->apiRepository->baseAnswer()
                ->setMessage('ps list successfully fetched !')
                ->setStatus('success')
                ->setData($processList)
        );

    }
    //Create a directory with user's specified name in "/opt/myprogram/" director

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createDirectory(Request $request){

        $directoryCreated=CreateDirectory::dispatch($request->directory_name);
        if($directoryCreated)
            return response()->json(
                $this->apiRepository->baseAnswer()
                    ->setMessage('directory created successfully !')
                    ->setStatus('success')
                    ->setData($directoryCreated)
            );
        else
            return response()->json(
                $this->apiRepository->baseAnswer()
                    ->setMessage('directory already exists !')
                    ->setStatus('failed')
                    ->setData($directoryCreated)
            );

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFile(Request $request){


        $fileCreated=  $this->apiRepository->createFile($request->file_name);

//      $fileCreated=CreateFile::dispatch$request->file_name;

        return response()->json(
            $this->apiRepository->baseAnswer()
                ->setMessage('file created successfully !')
                ->setStatus('success')
                ->setData($fileCreated)
        );

    }



}
