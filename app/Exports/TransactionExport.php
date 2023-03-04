<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Http\Resources\TransactionResource;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Resources\ExportResource;

class TransactionExport implements FromCollection
{
    protected $user_id;

    function __construct($user_id) {
        $this->user_id = $user_id;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $order = Transaction::where('user_id',$this->user_id)->get();
        $orderData = TransactionResource::collection($order->loadMissing(['product', 'user']));

        // foreach ($orderData as $key => $value) {
        //     $data[] = [
        //         'name' => $value['product']['name'],
        //         'description' => $value['product']['description'],
        //         'price' => $value['product']['price'],
        //         'created_at' => $value['product']['created_at'],
        //     ];
        // }

        // dd($order);
        return ExportResource::collection($orderData);
    }
}
