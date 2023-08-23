<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use App\Events\UserSignup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail implements ShouldQueue
{
    use InteractsWithQueue;

    public $afterCommit = true;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    // public $delay = 6;

    public function handle(UserSignup $event): void
    {
        Mail::to($event->user->email)->send(new WelcomeMail($event->user));
    }
}
