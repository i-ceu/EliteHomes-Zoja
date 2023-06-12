<?php

namespace App\Listeners;

use App\Events\BookTour;
use App\Mail\BookingMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingMail
{
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
    public function handle(BookTour $event): void
    {
        Mail::to($event->user->email)->send(new BookingMail($event->user));
    }
}
