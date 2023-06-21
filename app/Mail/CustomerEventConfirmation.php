<?php

namespace App\Mail;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerEventConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $events;
    public $subscription;

    /**
     * Create a new message instance.
     */
    public function __construct($events, $subscriptionId)
    {
        $this->events = $events;
        $this->subscription = Subscription::withCount("events")->find(
            $subscriptionId
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: "Bestellbestätigung Sensopro Termine");
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(view: "emails.CustomerEventConfirmation");
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
