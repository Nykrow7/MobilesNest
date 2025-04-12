<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index(Request $request)
    {
        $query = Transaction::with('order.user')
            ->orderBy('created_at', 'desc');

        // Apply sorting if provided
        if ($request->has('column') && $request->has('sort')) {
            $column = $request->input('column');
            $direction = $request->input('sort');
            $sortableColumns = ['id', 'transaction_number', 'amount', 'payment_method', 'status', 'created_at'];

            if (in_array($column, $sortableColumns)) {
                $query->orderBy($column, $direction);
            }
        }

        $transactions = $query->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('order.items.product', 'order.user');

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Process a payment for an order.
     */
    public function processPayment(Request $request, Order $order)
    {
        // Validate request
        $validated = $request->validate([
            'payment_method' => 'required|string|in:gcash,cash_on_delivery',
            'gcash_number' => 'required_if:payment_method,gcash',
        ]);

        try {
            // Check if a transaction already exists for this order
            $existingTransaction = Transaction::where('order_id', $order->id)->first();

            if ($existingTransaction) {
                // Update existing transaction
                $transaction = $existingTransaction;
                $transaction->payment_method = $validated['payment_method'];
                $transaction->payment_details = $this->getPaymentDetails($request);
                $transaction->status = 'pending'; // Reset status for retry
            } else {
                // Create new transaction record
                $transaction = new Transaction([
                    'order_id' => $order->id,
                    'transaction_number' => Transaction::generateTransactionNumber(),
                    'amount' => $order->final_amount,
                    'payment_method' => $validated['payment_method'],
                    'status' => 'pending',
                    'payment_details' => $this->getPaymentDetails($request),
                ]);
            }

            // In a real application, you would integrate with a payment gateway here
            // For demo purposes, we'll simulate a successful payment
            $paymentSuccessful = $this->processPaymentWithGateway($transaction, $request);

            if ($paymentSuccessful) {
                $transaction->status = 'completed';
                $order->payment_status = 'paid';
                $order->save();
            } else {
                $transaction->status = 'failed';
            }

            $transaction->save();

            if ($paymentSuccessful) {
                // Log successful payment
                \Illuminate\Support\Facades\Log::info('Payment successful for order: ' . $order->id);

                // Update order status to processing
                $order->status = 'processing';
                $order->save();

                // Create a session variable to store the transaction ID for admin reference
                session(['last_transaction_id' => $transaction->id]);

                // Flash a success message with transaction details
                $successMessage = 'Order Successful! Your order #' . $order->order_number . ' has been placed. ' .
                                 'Transaction #' . $transaction->transaction_number . ' has been recorded.';

                // Redirect to shop phones page
                return redirect()->route('shop.index')
                    ->with('success', $successMessage);
            } else {
                // Log failed payment
                \Illuminate\Support\Facades\Log::error('Payment failed for order: ' . $order->id);

                return redirect()->back()
                    ->with('error', 'Payment processing failed. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'An error occurred while processing your payment. Please try again later.');
        }
    }

    /**
     * Process payment with payment gateway (simulated).
     */
    private function processPaymentWithGateway(Transaction $transaction, Request $request)
    {
        // In a real application, this would integrate with a payment gateway API
        // For demo purposes, we'll simulate a successful payment

        // Log the transaction attempt
        \Illuminate\Support\Facades\Log::info('Processing payment for order: ' . $transaction->order_id . ' with method: ' . $transaction->payment_method);

        // Always return true for demo purposes
        return true;
    }

    /**
     * Get payment details from request.
     */
    private function getPaymentDetails(Request $request)
    {
        $details = [];

        switch ($request->payment_method) {
            case 'gcash':
                $details = [
                    'gcash_number' => $request->gcash_number,
                    'reference' => $request->reference ?? null,
                ];
                break;

            case 'cash_on_delivery':
                $details = [
                    'notes' => $request->notes ?? 'Cash on delivery',
                ];
                break;
        }

        return $details;
    }
}