<?php

namespace App\Http\Controllers;

use App\Jobs\CreateDirectory;
use App\Jobs\GetRunningProcessList;
use App\Jobs\repairSystem;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRunningProcessesList(Request $request){

        $processList=GetRunningProcessList::dispatch();
        return response()->json(
            baseAnswer()
                ->setMessage('ps list successfully fetched !')
                ->setStatus('success')
                ->setData($processList)
        );

    }
    //Create a directory with user's specified name in "/opt/myprogram/" director
    public function createDirectory(Request $request){

        $directoryCreated=CreateDirectory::dispatch();
        if($directoryCreated)
        return response()->json(
            baseAnswer()
                ->setMessage('directory created successfully !')
                ->setStatus('success')
                ->setData($directoryCreated)
        );
        else
            return response()->json(
                baseAnswer()
                    ->setMessage('directory already exists !')
                    ->setStatus('failed')
                    ->setData($directoryCreated)
            );

    }
    public function createFile(Request $request){

        $fileCreated=CreateFile::dispatch();
        if($fileCreated)
        return response()->json(
            baseAnswer()
                ->setMessage('file created successfully !')
                ->setStatus('success')
                ->setData($fileCreated)
        );
        else
            return response()->json(
                baseAnswer()
                    ->setMessage('file already exists !')
                    ->setStatus('failed')
                    ->setData($fileCreated)
            );

    }



}
