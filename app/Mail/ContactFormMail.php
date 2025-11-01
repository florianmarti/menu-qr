<?php
// app/Mail/ContactFormMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $senderName;
    public $senderEmail;
    public $senderMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $message)
    {
        $this->senderName = $name;
        $this->senderEmail = $email;
        $this->senderMessage = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // >>>>>>>>>>>>>> INICIO DE CÓDIGO CORREGIDO <<<<<<<<<<<<<<<<
        // Hemos eliminado el encabezado 'replyTo'
        // que estaba causando el conflicto con Mailtrap.
        return new Envelope(
            subject: 'Nuevo Mensaje de Contacto - ' . config('app.name'),
        );
        // >>>>>>>>>>>>>> FIN DE CÓDIGO CORREGIDO <<<<<<<<<<<<<<<<<<
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-form',
            with: [
                'name' => $this->senderName,
                'email' => $this->senderEmail,
                'messageBody' => $this->senderMessage,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
