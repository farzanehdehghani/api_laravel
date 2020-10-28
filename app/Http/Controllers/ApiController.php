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

        $processList=GetRunningProcessList::dispatch();
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

        $process = new Process(['pwd']);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();


        $fileCreated=CreateFile::dispatch($request->file_name);
        if($fileCreated)
        return response()->json(
            $this->apiRepository->baseAnswer()
                ->setMessage('file created successfully !')
                ->setStatus('success')
                ->setData($fileCreated)
        );
        else
            return response()->json(
                $this->apiRepository->baseAnswer()
                    ->setMessage('file already exists !')
                    ->setStatus('failed')
                    ->setData($fileCreated)
            );

    }



}
