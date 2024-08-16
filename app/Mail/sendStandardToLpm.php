<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendStandardToLpm extends Mailable
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
      return $this->subject('🔔 AMI | Auditor Standards Have Been Created by Admin'
      )->view('mail.sendStandardToLpm',[
            'data' => $this->data
      ]);
      }
}
