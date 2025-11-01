<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate(3);
        return view('transactions.index', compact('transactions'));
    }


}
