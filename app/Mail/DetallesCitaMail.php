<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class DetallesCitaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $infoCita;
    public $estudios;
    public $total;
    public $folio;

    public function __construct($folio, $infoCita, $estudios, $total)
    {
        $this->infoCita = $infoCita;
        $this->estudios = $estudios;
        $this->total = $total;
        $this->folio = $folio;
        // file_put_contents('./debug.log', print_r($this->estudios, true), FILE_APPEND);    
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('notificaciones@cdmilab.com', 'CDMI'),//Esto es para que no tome por defecto el address y el name del .env
            subject: 'Detalles de tu Cita',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.detallesCita',
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
