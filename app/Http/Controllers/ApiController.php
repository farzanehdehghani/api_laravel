<?php

namespace App\Http\Controllers;

use App\Jobs\GetRunningProcessList;
use App\Jobs\repairSystem;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function getRunningProcessesList(){

        $processList=GetRunningProcessList::dispatch();
        return response()->json(
            baseAnswer()
                ->setMessage('ps list successfully fetched !')
                ->setStatus('success')
                ->setData($processList)
        );

    }

    public function getRunningProcessesList(Request $request){


        //ip & user & password checked in the middleware
        //checking if all the values are present on the request and are not empty . ->has will just check the presence of value.
        if (!$request->filled(['enduser','text','send_time'])) {//requestId, user, text ,'priority', content_id , enduser , message_type,send_time , priority
            Log::channel('send_sms_api')->info("insufficient value for SendSMS request ! missing enduser / text / send_time. info: api account=".$request->input('user'));
            return json_encode(["result"=> -1, "status"=>"error", "desc"=>"Missing value!"]);
        }

        $actions= new \App\Services\actions();
        $_enduser=$actions->convertToEnglishNumber(trim($request->enduser));
        $is_valid_phone=$actions->is_valid_cell_phone($_enduser);
        if(!$is_valid_phone){
            Log::channel('send_sms_api')->info("InCorrect enduser value for SendSMS request ! invalid enduser . info: api account=".$request->input('user'));
            return json_encode(["result"=> -2, "status"=>"error", "desc"=>"Invalid enduser:'$_enduser'!"]);
        }

        // $request=$request->query();
        //TODO: validation, for timestamp

        $requestAll = $request->all();
        $requestAll['enduser']= $_enduser;
        Log::channel('send_sms_api')->info($requestAll);
        Log::channel('send_sms_api')->info($requestAll['enduser']);

        //send time
        if(!$request->has("send_time")||trim($requestAll['send_time'])=="now") {
            $requestAll['send_time'] = strtotime("now");
        } else{
            $isValidTimeStamp= $this->isValidTimeStamp($request->send_time);
            if(!$isValidTimeStamp)
                return json_encode(["result"=> -3, "status"=>"error", "desc"=>"Invalid send_time:'$request->send_time'!"]);
        }
        //expiry time
        if(!$request->has('expiry_time'))//get from panel
            $requestAll['expiry_time']= strtotime("1 days");


        $apiAccount=$this->getUserIdAndApiAccountIdFromName( $requestAll['user'] );
        $requestAll['api_account_id']= $apiAccount->id;
        $requestAll['user']= $apiAccount->user_id;

        if($request->has('message_type')) {
            if ($request->message_type == 'ads')
                $requestAll['message_type'] = 'ads';
        }
        else
            $requestAll['message_type']='services';

        //store to db
        $status='pending';
        $message_id=$this->storeIntoMessagesTable($requestAll,$status);//difference with no type for arg

        $actions= new \App\Services\actions();
        $actions->insertIntoLogsTable($message_id,['status'=>'pending']);

        sendSmsMessages::dispatch();

        return json_encode(["result"=>1,"status"=>"success","message_id"=>$message_id]);

    }

}
