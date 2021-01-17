<template>
    <div class="container">
        <h2 class="mt-4" style="text-align: center">История операций</h2>
        <div class="card mt-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Пользователь</th>
                            <th>Отправляете</th>
                            <th>Получаете</th>
                            <th>Сумма</th>
                            <th>К получению</th>
                            <th>Кошелек</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="t in transactions.data">
                                <td>{{ t.id }}</td>
                                <td><a :href="`/admin/users/${t.user_id}`">{{ t.user.name }}</a></td>
                                <td>{{ t.from_currency.name }}</td>
                                <td>{{ t.to_currency.name }}</td>
                                <td>{{ prettifyNumber(t.base_amount) }} {{ t.from_currency.name }}</td>
                                <td>{{ prettifyNumber(t.result_amount) }} {{ t.to_currency.name }}</td>
                                <td>{{ t.wallet }}</td>
                                <td>{{ getStatus(t.status) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <pagination :data="transactions" @pagination-change-page="getTransactions"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            transactions: []
        }
    },
    mounted() {
        this.getTransactions();
    },
    methods: {
        getTransactions(page = 1) {
            this.$axios.get('/api/transaction/list?page=' + page).then((response) => {
                this.transactions = response.data;
            })
        }
    }
}
</script>