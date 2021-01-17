<template>
    <div class="container mt-4">
        <h2>Список пользователей</h2>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Кол-во транзакций</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data">
                                <th>{{ user.id }}</th>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ getRole(user.role) }}</td>
                                <td>{{ user.transactions_count }}</td>
                                <td>
                                    <a :href="`/admin/users/${user.id}`" class="btn btn-primary btn-sm">Просмотреть</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <pagination :data="users" @pagination-change-page="getUsers"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                users: []
            }
        },
        mounted() {
          this.getUsers();
        },
        methods: {
            getUsers(page = 1) {
                this.$axios.get('/api/users?page=' + page).then((response) => {
                   this.users = response.data;
                });
            }
        }
    }
</script>