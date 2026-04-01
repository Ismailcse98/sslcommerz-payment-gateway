<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Log;

class CheckPendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:check-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check pending payments';

    /**
     * Execute the console command.
     */
    public function handle(SslCommerzPaymentController $ssl)
    {
        $orders = Order::where('status', 'Pending')
            ->whereBetween('created_at', [
                now()->subMinutes(10),
                now()->subMinutes(2)
            ])
            ->get();

        Log::info('Scheduler Start', [
            'time' => now(),
            'pending_count' => $orders->count(),
        ]);

        foreach ($orders as $order) {
            $status = 'Failed';
            $response = $ssl->validatePayment(
                $order->transaction_id,
                $order->amount,
                $order->currency
            );

            if (
                isset($response['status']) &&
                $response['status'] == 'VALID'
            ) {
                $status = 'Completed';
                $order->status = 'Completed';
            } else {
                $order->status = 'Failed';
            }

            $order->save();

            Log::info('Order Checked by Scheduler', [
                'tran_id' => $order->tran_id,
                'status' => $status,
                'time' => now(),
            ]);
        }
        Log::info('Scheduler End', ['time' => now()]);
    }


}
