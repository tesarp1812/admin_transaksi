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

        // Seed customers
        for ($i = 0; $i < 20; $i++) {
            $customerId = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));

            DB::table('customer')->insert([
                'kode_customer' => $customerId,
                'nama_customer' => $faker->firstName,
                'alamat' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed barang

        $carNames = [
            'Toyota Corolla',
            'Honda Civic',
            'Ford Mustang',
            'Chevrolet Malibu',
            'Nissan Altima',
            'BMW 3 Series',
            'Mercedes-Benz C-Class',
            'Audi A4',
            'Volkswagen Jetta',
            'Hyundai Elantra',
        ];

        for ($i = 0; $i < 10; $i++) {
            $itemId = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));

            DB::table('barang')->insert([
                'kode_barang' => $itemId,
                'nama_barang' => array_pop($carNames),
                'stok' => $faker->numberBetween(1, 100),
                'harga' => $faker->randomFloat(2, 10, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create transactions
        for ($i = 0; $i < 20; $i++) {
            $transactionId = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)); // Random 5-char ID
            $customerId = DB::table('customer')->inRandomOrder()->first()->kode_customer; // Random customer ID

            $transactionDate = $faker->date();

            DB::table('transaksi')->insert([
                'no_transaksi' => $transactionId,
                'tgl_transaksi' => $transactionDate,
                'kode_customer' => $customerId,
                'total' => 0, // Set total to 0 initially
                'keterangan' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create transaction details
        $transactions = DB::table('transaksi')->pluck('no_transaksi');

        foreach ($transactions as $transactionId) {
            $numberOfDetails = $faker->numberBetween(1, 5); // Random number of details per transaction

            for ($j = 0; $j < $numberOfDetails; $j++) {
                $itemId = DB::table('barang')->inRandomOrder()->first()->kode_barang; // Random item ID

                DB::table('detail_transaksi')->insert([
                    'no_transaksi' => $transactionId,
                    'tgl_transaksi' => now(), // Use the current date
                    'kode_barang' => $itemId,
                    'urut' => $j + 1,
                    'qty' => $faker->numberBetween(1, 10),
                    'harga' => DB::table('barang')->where('kode_barang', $itemId)->value('harga'), // Get the price from the item
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Update the total in the transactions table
            $total = DB::table('detail_transaksi')->where('no_transaksi', $transactionId)->sum(DB::raw('qty * harga'));
            DB::table('transaksi')->where('no_transaksi', $transactionId)->update(['total' => $total]);
        }
    }
}
