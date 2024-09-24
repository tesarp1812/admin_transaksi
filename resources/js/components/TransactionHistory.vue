<template>
  <div class="container mt-5">
    <h1>History Transaksi</h1>

    <div v-if="message" class="alert alert-success">{{ message }}</div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No Transaksi</th>
          <th>Tanggal Transaksi</th>
          <th>Total</th>
          <th>Keterangan</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="transaction in transactions" :key="transaction.no_transaksi">
          <td>{{ transaction.no_transaksi }}</td>
          <td>{{ transaction.tgl_transaksi }}</td>
          <td>{{ transaction.total.toFixed(2) }}</td>
          <td>{{ transaction.keterangan || '-' }}</td>
          <td>
            <button class="btn btn-info" @click="toggleDetails(transaction.no_transaksi)">Details</button>
            <div v-if="showDetails[transaction.no_transaksi]">
              <ul>
                <li v-for="detail in transaction.details" :key="detail.urut">
                  {{ detail.barang.nama_barang }} - Qty: {{ detail.qty }} - Harga: {{ detail.harga }} - Subtotal: {{ detail.subtotal }}
                </li>
              </ul>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      transactions: [],
      message: null,
      showDetails: {},
    };
  },
  methods: {
    fetchTransactions() {
      fetch('/api/transactions')
        .then(response => response.json())
        .then(data => {
          this.transactions = data.data;
          this.message = data.message;
        })
        .catch(error => {
          console.error('Error fetching transactions:', error);
        });
    },
    toggleDetails(noTransaksi) {
      this.$set(this.showDetails, noTransaksi, !this.showDetails[noTransaksi]);
    },
  },
  created() {
    this.fetchTransactions();
  },
};
</script>

<style scoped>
.table {
  margin-top: 20px;
}
</style>
