<?php

namespace App\Listeners;

use App\Events\Login;
use App\Events\Logout;
use App\Events\Created;
use App\Mail\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    public function handleUserLogin($event)
    {
    }

    public function handleUserLogout($event){}

    public function handleUserCreated($event)
    {
        Mail::to("admin@cicd.biz")->queue(new UserCreated($event->user));
    }

    public function subscribe($events)
    {
        return [
            Login::class => 'handleUserLogin',
            Logout::class => 'handleUserLogout',
            Created::class => 'handleUserCreated'
        ];
    }
}
