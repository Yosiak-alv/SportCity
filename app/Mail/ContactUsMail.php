<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    /**
     * Create a new message instance.
     */
    public function __construct($formData)
    {
        $this->mailData = $formData;
    }

    
    public function build()
    {		
		return $this->view('emails.contact-us')->subject("We're excited to see you keep in touch")->with(['data' => $this->mailData]);
    }
}
