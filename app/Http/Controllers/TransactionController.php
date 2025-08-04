<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    
        /**
     * Show a list of all transactions.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Overall Totals (for all time)
        // Ensure you reset the query for each sum if chaining where clauses
        $totalIncome = $user->transactions()->where('type', 'income')->sum('amount');
        $totalExpenses = $user->transactions()->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;


        // 2. Current Month Totals
        $currentMonth = Carbon::now();
        $currentMonthIncome = $user->transactions()
                                   ->where('type', 'income')
                                   ->whereMonth('created_at', $currentMonth->month)
                                   ->whereYear('created_at', $currentMonth->year)
                                   ->sum('amount');

        $currentMonthExpenses = $user->transactions()
                                    ->where('type', 'expense')
                                    ->whereMonth('created_at', $currentMonth->month)
                                    ->whereYear('created_at', $currentMonth->year)
                                    ->sum('amount');

        $currentMonthNetBalance = $currentMonthIncome - $currentMonthExpenses;

        // 3. Data for Monthly Trends Chart (e.g., last 6 months)
        $months = [];
        $monthlyIncomeData = [];
        $monthlyExpenseData = [];

        // Loop for the last 6 months (including current)
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M'); // e.g., "Jan", "Feb", "Jul"
            $months[] = $monthName;

            $income = $user->transactions()
                           ->where('type', 'income')
                           ->whereMonth('created_at', $date->month)
                           ->whereYear('created_at', $date->year)
                           ->sum('amount');
            $monthlyIncomeData[] = round($income, 2); // Round for cleaner chart data

            $expense = $user->transactions()
                            ->where('type', 'expense')
                            ->whereMonth('created_at', $date->month)
                            ->whereYear('created_at', $date->year)
                            ->sum('amount');
            $monthlyExpenseData[] = round($expense, 2); // Round for cleaner chart data
        }


        // 4. Data for Expense Categories Chart (DUMMY DATA - Requires 'category' column to be dynamic)
        $expenseCategoryLabels = ['Food', 'Transport', 'Rent', 'Utilities', 'Entertainment', 'Other'];
        $expenseCategoryAmounts = [500, 300, 1200, 150, 200, 100]; // Placeholder values


        // 5. Get recent transactions for the table display (e.g., last 10)
        $transactions = $user->transactions()->latest()->take(10)->get();


        // 6. Pass ALL this information to the 'index' view
        return view('transactions.index', compact(
            'transactions',
            'totalIncome',
            'totalExpenses',
            'netBalance',
            'currentMonthIncome',
            'currentMonthExpenses',
            'currentMonthNetBalance',
            'months',                 // For monthly trend chart labels
            'monthlyIncomeData',      // For monthly trend chart income data
            'monthlyExpenseData',     // For monthly trend chart expense data
            'expenseCategoryLabels',  // For expense categories chart labels (dummy)
            'expenseCategoryAmounts'  // For expense categories chart data (dummy)
        ));
    }

    /**
     * Show the form to create a new transaction.
     */
    public function create()
    {
        // Just show the 'create' page (the form)
        return view('transactions.create');
    }

    /**
     * Store a newly created transaction in the database.
     */
    public function store(Request $request)
    {
        // Make sure the data coming from the form is good
        $validatedData = $request->validate([ // Use a variable for validated data
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            // 'category' => 'nullable|string|max:100',
        ]);

        // Create a new Transaction and AUTOMATICALLY link it to the logged-in user
        Auth::user()->transactions()->create($validatedData);

        // After saving, go back to the page that lists all transactions
        return redirect('/transactions')->with('success', 'Transaction recorded successfully!');
    }
}
