<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AplikasiMengaji extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
   public $isi;

   public function __construct($isi)
   {
       $this->isi = $isi;
   }

   /**
    * Build the message.
    *
    * @return $this
    */
   public function build()
   {
       return $this->from('ngajiapp@stackapps.id')
       ->view('email.reset')
       ->with([
           'isi'  => $this->isi,
       ]);
   }
}
