<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\TransactionResource;

class ExportController extends Controller
{
    public function index($user_id)
    {
        return Excel::download(new TransactionExport($user_id), 'Orders.xlsx');
    }
}
