<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Console\Command;

class SyncOrderTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:sync-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensure all orders have corresponding transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to sync order transactions...');

        // Get all orders that have been paid but don't have transactions
        $orders = Order::where('payment_status', 'paid')
            ->whereDoesntHave('transaction')
            ->get();

        $count = 0;

        foreach ($orders as $order) {
            // Create a transaction for the order
            $transaction = new Transaction([
                'order_id' => $order->id,
                'transaction_number' => Transaction::generateTransactionNumber(),
                'amount' => $order->final_amount,
                'payment_method' => $order->payment_method,
                'status' => 'completed',
                'payment_details' => [
                    'synced' => true,
                    'synced_at' => now()->toDateTimeString(),
                ],
            ]);

            $transaction->save();
            $count++;

            $this->info("Created transaction for order #{$order->order_number}");
        }

        $this->info("Completed syncing transactions. Created {$count} new transactions.");
    }
}
