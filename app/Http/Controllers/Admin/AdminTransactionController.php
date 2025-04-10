<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['order.user']);

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment method if provided
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range if provided
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by transaction number, order number, or customer name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                  ->orWhereHas('order', function($q) use ($search) {
                      $q->where('order_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                  });
            });
        }

        // Apply sorting if provided
        if ($request->has('column') && $request->has('sort')) {
            $column = $request->input('column');
            $direction = $request->input('sort');

            // Map column index to actual column name
            $columnMap = [
                0 => 'id',
                1 => 'transaction_number',
                4 => 'amount',
                5 => 'payment_method',
                6 => 'status',
                7 => 'created_at',
            ];

            if (isset($columnMap[$column])) {
                $query->orderBy($columnMap[$column], $direction);
            }
        } else {
            // Default sorting - most recent transactions first
            $query->latest('created_at');
        }

        $transactions = $query->paginate(10)->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['order.user', 'order.items.product']);
        return view('admin.transactions.show', compact('transaction'));
    }
}