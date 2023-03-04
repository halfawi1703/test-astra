<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\TransactionsExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $order = Transaction::all()->where('user_id', $user->id);
        
        return TransactionResource::collection($order->loadMissing(['product', 'user']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $request['user_id'] = auth()->user()->id;
        $order = Transaction::create($request->all());

        return response()->json(['Message' => 'Sucess order']);
    }

    public function update(Request $request, $id)
    {
        # code...
    }

    public function destroy($id)
    {
        $order = Transaction::findOrFail($id);
        $order->delete();

        return New TransactionResource($order->loadMissing(['product', 'user']));
    }
}
