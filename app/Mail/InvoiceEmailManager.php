<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceEmailManager extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $array;

    public function __construct($array)
    {
        $this->array = $array;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
     {
        $email = $this->view($this->array['view'])
        ->from($this->array['from'], env('MAIL_FROM_NAME'))
        ->subject($this->array['subject'])
        ->with([
            'order' => $this->array['order'],
        ]);

            // Check if 'booking' exists in the array
            if (isset($this->array['booking'])) {
            $email->with([
            'booking' => $this->array['booking'],
            ]);
            }

            return $email;
                }
}
