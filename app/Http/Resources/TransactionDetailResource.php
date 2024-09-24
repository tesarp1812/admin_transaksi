<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'urut' => $this->urut,
            'no_transaksi' => $this->no_transaksi,
            // 'tgl_transaksi' => $this->tgl_transaksi,
            // 'kode_barang' => $this->kode_barang,
            'barang' => new ItemResource($this->whenLoaded('item')), 
            'qty' => $this->qty,
            'harga' => $this->harga,
            'subtotal' => $this->qty * $this->harga,
        ];
    }
}
