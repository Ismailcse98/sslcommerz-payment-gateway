<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class PaymentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $message_text;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $message_text)
    {
        $this->order = $order;
        $this->message_text = $message_text;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Status Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_status', // Email view
            with: [
                'tran_id' => $this->order->transaction_id,
                'amount' => $this->order->amount,
                'currency' => $this->order->currency,
                'status' => $this->order->status,
                'message_text' => $this->message_text,
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
