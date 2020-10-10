<?php

namespace App\Http\Middleware;

use App\ApiAccount;
use Closure;
use Log;
use \App\User;

class RestrictInvalidIp
{
    //fetch from db
    /**
    protected $ips = [
    '127.0.0.1', '93.118.148.184','173.212.225.175','173.249.14.167','173.212.234.247',
    '80.253.147.99' , '5.160.8.139' , '10.7.217.99' , '5.112.195.72' , '167.86.116.92',
    '78.159.99.21','78.159.99.42','78.159.99.44','185.51.201.145'
    ];*/

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $ip=$_SERVER['REMOTE_ADDR'];
        /** if (! $this->isValidIp($ip) ) {//&& ! $this->isValidIpRange($ip)
        Log::channel('ipcheck')->critical("Invalid Ip Called Api: $ip");//Todo: log into db
        return redirect('/');
        }*/

        if (!$request->filled(['user'])){
            Log::channel('ipcheck')->critical("Invalid uesrname or password Called Api, Ip: $ip");//Todo: log into db
            return redirect('/');
        }
        $requestAll = $request->all();
        $name=$requestAll['user'];
        $user=ApiAccount::where('name',$name)->first();
        /* $role=$user->roles()->pluck('name')->implode(' ');
        if (!$user->hasRole('ApiClient')&&!$user->hasRole('Admin')){//Super Client //work with permisions or roles
            Log::channel('ipcheck')->critical("Invalid [user] Called Api: $name | $ip");//Todo: log into db
            return redirect('/');
        }*/

        $user = \App\ApiAccount::where('name', $requestAll['user'])
            ->where('api_token', $requestAll['api_token'])
            // ->where('password', $request->query('password'))
            ->where('ip', $ip)//Todo review ip,$request->ip()
            ->first();

        /* ->where('password', $request->query('password'))
         ->get();*/

        if(empty($user)){
            Log::channel('ipcheck')->critical("Invalid [Ip&user&token] Called Api: $ip");//Todo: log into db
            return redirect('/');
        }

        Log::channel('ipcheck')->info("Request to Api from: $ip");

        return $next($request);
    }
    /**
    protected function isValidIp($ip){
    return in_array($ip, $this->ips);
    }
     */

}
