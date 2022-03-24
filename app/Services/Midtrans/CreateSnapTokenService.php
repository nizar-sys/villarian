<?php
 
namespace App\Services\Midtrans;
 
use \Midtrans\Snap;
use Illuminate\Support\Str;
 
class CreateSnapTokenService extends Midtrans
{
    protected $order;
 
    public function __construct($order)
    {
        parent::__construct();
 
        $this->order = $order;
    }
 
    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => Str::uuid(),
                'gross_amount' => $this->order->total_bayar,
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $this->order->villa->harga_sewa,
                    'quantity' => 1,
                    'name' => 'Sewa villa ' . $this->order->villa->nama_villa,
                ],
            ],
            'customer_details' => [
                'first_name' => $this->order->nama_pemesan,
                'email' => $this->order->user->email,
                'phone' => $this->order->no_hp,
            ]
        ];
 
        $snapToken = Snap::getSnapToken($params);
 
        return $snapToken;
    }
}