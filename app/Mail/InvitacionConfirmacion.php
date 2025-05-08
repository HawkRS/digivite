<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitacionConfirmacion extends Mailable
{
  use Queueable, SerializesModels;
  public $invitacion;

  /**
  * Create a new message instance.
  *
  * @return void
  */
  public function __construct($invitacion)
  {
    $this->invitacion = $invitacion;
  }
  
  /**
  * Build the message.
  *
  * @return $this
  */
  public function build()
  {
    return $this->subject('Confirma tu asistencia')
    ->view('emails.confirmacion');
  }

}

