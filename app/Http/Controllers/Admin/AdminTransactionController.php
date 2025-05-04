<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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

    /**
     * Export transactions data based on the requested format.
     *
     * @param string $type The export type (csv, excel, pdf)
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\Response
     */
    public function export(Request $request, $type)
    {
        // Get the current query parameters to maintain filters
        $query = Transaction::with(['order.user']);

        // Apply the same filters as in the index method
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

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

        // Get all transactions for export
        $transactions = $query->get();

        // Prepare the data for export
        $data = [];
        foreach ($transactions as $transaction) {
            $data[] = [
                'ID' => $transaction->id,
                'Transaction Number' => $transaction->transaction_number,
                'Order Number' => $transaction->order->order_number,
                'Customer' => $transaction->order->user->name,
                'Amount' => $transaction->formatted_amount,
                'Payment Method' => ucfirst(str_replace('_', ' ', $transaction->payment_method)),
                'Status' => ucfirst($transaction->status),
                'Date' => $transaction->created_at->format('M d, Y H:i'),
            ];
        }

        // Export based on the requested type
        if ($type === 'csv') {
            return $this->exportToCsv($data);
        } else {
            // For now, we'll just use CSV for all types until the packages are installed
            return $this->exportToCsv($data);
        }
    }

    /**
     * Export data to CSV format.
     *
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private function exportToCsv($data)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="transactions-' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // Add headers only if there's data
            if (!empty($data)) {
                fputcsv($file, array_keys($data[0]));
            }

            // Add data
            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}