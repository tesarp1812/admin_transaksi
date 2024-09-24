import { createApp } from 'vue';
import TransactionHistory from './components/TransactionHistory.vue';

const app = createApp({});
app.component('transaction-history', TransactionHistory);
app.mount('#app');
