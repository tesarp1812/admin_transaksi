<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $faker = Faker::create('id_ID');

        //faker user kepala
        for ($i = 0; $i < 20; $i++) {
            $userId = Str::uuid(); // Membuat UUID baru

            DB::table('customers')->insert([
                'kode_customer' => $userId,
                'nama_customer' => $faker->firstName,
                'alamat' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 0; $i < 20; $i++) {
            $itemId = Str::uuid(); // Membuat UUID baru

            DB::table('items')->insert([
                'kode_barang' => $itemId,
                'nama_barang' => $faker->word,
                'stok' => $faker->numberBetween(1, 100),
                'harga' => $faker->randomFloat(2, 10, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // Create Transactions
        for ($i = 0; $i < 20; $i++) {
            $transactionId = Str::uuid(); // Create a new UUID
            $customerId = DB::table('customers')->inRandomOrder()->first()->kode_customer; // Random customer ID

            DB::table('transactions')->insert([
                'no_transaksi' => $transactionId,
                'tgl_transaksi' => $faker->date(),
                'kode_customer' => $customerId,
                'total' => 0, // Set total to 0 initially, will calculate later
                'keterangan' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create Transaction Details
        $transactions = DB::table('transactions')->pluck('no_transaksi'); // Get all transaction IDs

        foreach ($transactions as $transactionId) {
            $numberOfDetails = $faker->numberBetween(1, 5); // Random number of details per transaction
        
            for ($j = 0; $j < $numberOfDetails; $j++) {
                $itemId = DB::table('items')->inRandomOrder()->first()->kode_barang; // Random item ID
                $detailId = Str::uuid(); // Create a new UUID for transaction detail
        
                DB::table('transaction_details')->insert([
                    'id_transaksi' => $detailId, // Add the UUID here
                    'no_transaksi' => $transactionId,
                    'tgl_transaksi' => now(), // Use the current date
                    'kode_barang' => $itemId,
                    'urut' => $j + 1,
                    'qty' => $faker->numberBetween(1, 10),
                    'harga' => DB::table('items')->where('kode_barang', $itemId)->value('harga'), // Get the price from the item
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        
            // Update the total in the transactions table
            $total = DB::table('transaction_details')->where('no_transaksi', $transactionId)->sum(DB::raw('qty * harga'));
            DB::table('transactions')->where('no_transaksi', $transactionId)->update(['total' => $total]);
        }
    }
}
