<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class RestrictInvalidIp
{
    //fetch from db
    /**
    protected $ips = [
    '194.5.195.128'
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

        // $ip=$_SERVER['REMOTE_ADDR'];
        /** if (! $this->isValidIp($ip) ) {//&& ! $this->isValidIpRange($ip)
        return redirect('/');
        }*/

        if (!$request->filled(['user','api_token'])){
            return redirect('/');
        }
        $user = $request->user;
        $user = User::where('email',$user)
            ->where('api_token', $request->api_token) //->where('ip', $ip)
            ->first();

        if(empty($user)){
            return redirect('/');
        }

        return $next($request);
    }
    /**
    protected function isValidIp($ip){
    return in_array($ip, $this->ips);
    }
     */

}
