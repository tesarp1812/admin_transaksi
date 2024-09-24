<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdministrationControllers extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'API is working!']);
    }

    public function dataTransaction()
    {
        $transactions = Transaction::with('details.item')->get();

        $status = 'success'; // Atur status sesuai kebutuhan
        $message = 'Transaksi berhasil diambil'; // Atur pesan sesuai kebutuhan

        return TransactionResource::collection($transactions->map(function ($transaction) use ($status, $message) {
            return new TransactionResource($status, $message, $transaction);
        }));
    }

    public function showHistory()
    {
        $transactions = Transaction::with('details.item')->get();

        return view('transactions.history', compact('transactions'));
    }


    public function getCustomers()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    public function getItem()
    {
        $items = Item::all();
        return response()->json($items);
    }

    public function createTransaction()
    {

        $customers = Customer::all(); // Fetch customers
        $items = Item::all(); // Fetch items
        // dd($customers);
        return view('transactions.create', compact('customers', 'items'));
    }

    public function storeJsonTransaction(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'kode_customer' => 'required|exists:customer,kode_customer',
            'total' => 'required|numeric|min:0',
            'details' => 'required|array',
            'details.*.kode_barang' => 'required|exists:barang,kode_barang',
            'details.*.qty' => 'required|integer|min:1',
            'details.*.harga' => 'required|numeric|min:0',
            'details.*.urut' => 'sometimes|integer', // Optional field
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Generate UUID untuk no_transaksi
        $noTransaksi = (string) Str::uuid();

        // Buat transaksi
        $transaction = Transaction::create([
            'no_transaksi' => $noTransaksi,
            'kode_customer' => $request->kode_customer,
            'tgl_transaksi' => now(),
            'total' => $request->total,
            'keterangan' => $request->keterangan ?? null,
        ]);

        // Simpan detail transaksi
        foreach ($request->details as $detail) {
            TransactionDetail::create([
                'id_transaksi' => (string) Str::uuid(), // Generate UUID untuk id_transaksi
                'no_transaksi' => $noTransaksi, // Menggunakan no_transaksi dari transaksi
                'kode_barang' => $detail['kode_barang'],
                'qty' => $detail['qty'],
                'harga' => $detail['harga'],
                'urut' => $detail['urut'] ?? 1,
                'tgl_transaksi' => now(),
            ]);
        }

        // Kembalikan respons
        return new TransactionResource(true, 'Transaction created successfully!', $transaction);
    }

    public function storeTransaction(Request $request)
    {
        // dd($request->all());
        // Validasi data
        $validator = Validator::make($request->all(), [
            'kode_customer' => 'required|exists:customer,kode_customer',
            'total' => 'required|numeric|min:0',
            'details' => 'required|array',
            'details.*.kode_barang' => 'required|exists:barang,kode_barang',
            'details.*.qty' => 'required|integer|min:1',
            'details.*.harga' => 'required|numeric|min:0',
            'details.*.urut' => 'sometimes|integer',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate kode unik untuk no_transaksi
        $noTransaksi = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)); // Menghasilkan kode unik 5 karakter

        // Buat transaksi
        Transaction::create([
            'no_transaksi' => $noTransaksi,
            'kode_customer' => $request->kode_customer,
            'tgl_transaksi' => now(),
            'total' => $request->total,
            'keterangan' => $request->keterangan ?? null,
        ]);

        // Simpan detail transaksi
        foreach ($request->details as $detail) {
            TransactionDetail::create([
                'no_transaksi' => $noTransaksi,
                'tgl_transaksi' => now(), // Tanggal transaksi
                'kode_barang' => $detail['kode_barang'],
                'qty' => $detail['qty'],
                'harga' => $detail['harga'],
                'urut' => $detail['urut'] ?? 1, // Urutan default 1 jika tidak ada
            ]);
        }

        // Redirect kembali dengan pesan sukses
        return redirect("/transaction/create")->with('success', 'Transaksi berhasil disimpan!');
    }
}
