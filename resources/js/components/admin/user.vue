<template>
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="user-info">
                    <h2>Информация о пользователе</h2>

                    <div class="field mt-5">
                        <b>Имя:</b>
                        <span>{{ user.name }}</span>
                    </div>

                    <div class="field mt-2">
                        <b>Email:</b>
                        <span>{{ user.email }}</span>
                    </div>

                    <div class="field mt-2">
                        <b>Дата регистрации:</b>
                        <span>{{ $moment(user.created_at).format('DD.MM.Y HH:MM') }}</span>
                    </div>

                    <div class="field mt-2">
                        <b>Роль:</b>
                        <span>{{ getRole(user.role) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h2>Транзакции пользователя</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
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
        props: ['user'],
        mounted() {
          this.getTransactions();
        },
        methods: {
            getTransactions(page = 1) {
                this.$axios.get('/api/transaction/user/list?page=' + page + '&user=' + this.user.id).then((response) => {
                    this.transactions = response.data;
                })
            },
        }
    }
</script>