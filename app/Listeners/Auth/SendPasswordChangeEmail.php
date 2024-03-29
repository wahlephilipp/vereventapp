<?php

namespace App\Listeners\Auth;


use App\Mail\PasswordReset as PasswordResetMail;
use Illuminate\Auth\Events\PasswordReset as PasswordResetEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordChangeEmail implements ShouldQueue
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
    public function handle(PasswordResetEvent $event)
    {
        Mail::to($event->user->email)
              ->send(new PasswordResetMail($event->user));
    }
}
