<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationUpdated extends Mailable
{
    use Queueable, SerializesModels;

    private $application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.application-updated', [
            'status' => $this->application->status,
            'comments' => $this->application->comments
        ]);
    }
}
