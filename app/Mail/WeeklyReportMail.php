<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateEmailVerifyMail extends Mailable
{
    use Queueable;
    use SerializesModels;


    public function __construct(public $reportData)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): Mailable
    {
        return $this->view('email.report-email')->subject('Weekly Report');
    }
}
