<?php

namespace App\Listeners;
use Illuminate\Auth\Events\Registered;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CreateUserDirectory
{

//    public function __construct(Authenticatable $user)
//    {
//
//    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $userName=$event->user->email;
        $process = new Process(['mkdir', "/opt/myprogram/$userName"]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();

    }
}
