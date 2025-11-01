<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $month = 12;
        $successTransactions = Transaction::getData(month: $month, status: 1);
        $successTransactionsChart = $this->chartData($successTransactions, $month);

        return view('dashboard', compact('successTransactionsChart'));
    }

    public function chartData($transactions, $month)
    {
        $result = [];
        $monthName = $transactions->map(function ($item) {
            return verta($item->created_at)->format('%B %Y');
        });

        $amount = $transactions->map(function ($item) {
            return $item->amount;
        });
        // dd($monthName, $amount);

        foreach ($monthName as $i => $v) {
            if (!isset($result[$v])) {
                $result[$v] = 0;
            }

            $result[$v] += $amount[$i];
        }

        if (count($result) != $month) {
            for ($i = 0; $i < $month; $i++) {
                $monthName = verta()->subMonths($i)->format('%B %Y');
                $shamsiMonths[$monthName] = 0;
            }
            $data = array_merge($shamsiMonths, $result);

            $finalResult = [];
            foreach ($data as $month => $val) {
                array_push($finalResult, ['month' => $month, 'value' => $val]);
            }

            return $finalResult;
        }

        $finalResult = [];
        foreach ($result as $month => $val) {
            array_push($finalResult, ['month' => $month, 'value' => $val]);
        }

        return $finalResult;
    }
}
