<template>
    <div class="container page-content">
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <sidebar-module ref="sidebar"></sidebar-module>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-12 mt-3 mt-lg-0">
                <div class="card">
                    <div class="card-body exchange-block">
                        <div class="pairs">
                            <div>
                                <h3>Отдаете - {{ pair1 }}</h3>
                                <input type="number" class="form-control mt-3" placeholder="Укажите сумму" @input="calculateGet" v-model="give">
                            </div>
                            <div class="arrow-block">
                                <h6>Курс обмена 1 {{ pair1 }} = {{ rate }} {{ pair2 }}</h6>
                                <img src="https://tyt.cash/wp-content/themes/TYT/img/arrows.png" alt="arrow-right">
                            </div>
                            <div>
                                <h3>Получаете - {{ pair2 }}</h3>
                                <input type="number" class="form-control mt-3" placeholder="Укажите сумму" v-model="get" @input="calculateGive">
                            </div>
                        </div>

                        <div>
                            <div class="form-group mt-3 pl-4">
                                <label>Номер карты \ Адрес кошелька</label>
                                <input type="text" class="form-control" v-model="wallet">
                            </div>

                            <button @click="exchange" class="btn btn-primary mt-3">Подтвердить операцию</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                rates: [],
                pair1: 'BTC',
                pair2: 'USD',
                rate: 0,
                give: 0,
                get: 0,
                wallet: null
            }
        },
        mounted() {
            this.getRates();
        },
        methods: {
            getRates() {
                this.$axios.get('/api/rates').then((response) => {
                   this.rates = response.data[0];
                   this.updatePairs();
                   this.updateRate();
                });
            },
            updatePairs() {
                let pairs = [];

                this.rates.map((el) => {
                   pairs.push(el.name);
                });

                this.$refs.sidebar.pair1 = this.pair1;
                this.$refs.sidebar.pair2 = this.pair2;

                this.$refs.sidebar.pairs = pairs;
            },
            updateRate() {
                let el1 = this.rates.filter((el) => {
                    return el.name === this.pair1
                });

                let el2 = this.rates.filter((el) => {
                    return el.name === this.pair2
                });

                let rate = (el1[0].rate / el2[0].rate);

                if (this.pair2 === 'BTC' || this.pair2 === 'ETH')
                    this.rate = rate.toFixed(8);
                else
                    this.rate = rate.toFixed(2);
            },
            calculateGet() {
                if (this.pair2 === 'BTC' || this.pair2 === 'ETH')
                    this.get = (this.give * this.rate).toFixed(8);
                else
                    this.get = (this.give * this.rate).toFixed(2);
            },
            calculateGive() {
                if (this.pair2 === 'BTC' || this.pair2 === 'ETH')
                    this.give = (this.get / this.rate).toFixed(8);
                else
                    this.give = (this.get / this.rate).toFixed(2);
            },
            exchange() {
                if (this.give <= 0) {
                    this.$toast.error('Неверная сумма');
                    return false;
                }

                if (!this.$refs.sidebar.pairs.includes(this.pair1)
                    || !this.$refs.sidebar.pairs.includes(this.pair2)
                ) {
                    this.$toast.error('Неверно указаны валютные пары');
                    return false;
                }

                if (!this.wallet) {
                    this.$toast.error('Кошелек\\Карта - обязательно поле для заполнения');
                    return false;
                }

                let request = {
                    pair1: this.pair1,
                    pair2: this.pair2,
                    amount: this.give,
                    wallet: this.wallet
                }

                this.$axios.post('/api/transaction/create', request).then((response) => {
                    if (response.data.success) {
                        this.$toast.success(response.data.success);

                        this.wallet = null;
                        this.give = 0;
                        this.get = 0;
                    }

                    if (response.data.error)
                        this.$toast.error(response.data.error);
                }).catch((error) => {
                    // Server error
                    if (error.response.status === 401)
                        this.$toast.error(error.response.data.message);
                });
            }
        },
        watch: {
            give: function(value) {
                if (value < 0)
                    this.give = 0;

                // Проверка на числа формата 01, 001
                if (value.toString()[0] === '0' && value.toString()[1] !== '.') {
                    this.give = 0;
                    this.calculateGet();
                }
            },
            get: function(value) {
                if (value < 0)
                    this.get = 0;

                // Проверка на числа формата 01, 001
                if (value.toString()[0] === '0' && value.toString()[1] !== '.') {
                    this.get = 0;
                    this.calculateGive();
                }
            }
        }
    }
</script>