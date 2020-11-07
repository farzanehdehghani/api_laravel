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
    public function __construct(Request $request, ApiRepository $apiRepository)
    {

        $this->apiRepository= $apiRepository;
        $this->apiRepository= $this->apiRepository->setUserDirectory($request->user);

    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRunningProcessesList(Request $request){

        $processList=  $this->apiRepository->getRunningProcessesList();

        return response()->json(
            baseAnswer()
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
            return response()->json(
                baseAnswer()
                    ->setMessage('directory created successfully !')
                    ->setStatus('success')
                    ->setData($directoryCreated)
            );


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFile(Request $request){


        $fileCreated=  $this->apiRepository->createFile($request->file_name);

        return response()->json(
            baseAnswer()
                ->setMessage('file created successfully !')
                ->setStatus('success')
                ->setData($fileCreated)
        );

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDirectoryList(Request $request){

        $directoryList=  $this->apiRepository->getDirectoryList();

        return response()->json(
            baseAnswer()
                ->setMessage('directory list successfully fetched !')
                ->setStatus('success')
                ->setData($directoryList)
        );

    }
    public function getFileList(Request $request){

        $fileList=  $this->apiRepository->getFileList();

        return response()->json(
            baseAnswer()
                ->setMessage('file list successfully fetched !')
                ->setStatus('success')
                ->setData($fileList)
        );

    }



}
