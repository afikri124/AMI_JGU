<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class approveStandardToAdmin extends Mailable
{
      use Queueable, SerializesModels;

      public $data;

      /**
       * Create a new message instance.
       *
       * @return void
       */
      public function __construct($data)
      {
            $this->data = $data;
      }

      /**
       * Build the message.
       *
       * @return $this
       */
      public function build()
      {
      return $this->subject('🔔 AMI | Approve Standard For LPM'
      )->view('mail.approveStandardToAdmin',[
            'data' => $this->data
      ]);
      }
}
