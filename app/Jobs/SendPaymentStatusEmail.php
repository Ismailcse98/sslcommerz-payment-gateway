<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentStatusMail;
use Illuminate\Support\Facades\Log;

class SendPaymentStatusEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public $order;
    public $message_text;


    public function __construct($order, $message_text)
    {
        $this->order = $order;
        $this->message_text = $message_text;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // throw new \Exception("Intentional Fail for testing!");

        Mail::to('abc@gmail.com')
            ->send(new PaymentStatusMail($this->order, $this->message_text));
    }

    public function failed(\Exception $exception)
    {
        // Failed job logging
        Log::error("SendPaymentStatusEmail failed", [
            'error' => $exception->getMessage()
        ]);
    }
}
