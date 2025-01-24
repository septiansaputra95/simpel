<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogEmailFailure
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
    public function handle(MessageFailed $event)
    {
        $email = $event->message->getTo();
        $reason = $event->response;

        Log::error("Email gagal dikirim ke: " . json_encode($email));
        Log::error("Alasan kegagalan: " . $reason);
    }
}
