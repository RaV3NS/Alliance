<template>
    <div>
        <h3>Обмен валют</h3>

        <div class="form-group">
            <label>Отдадите</label>
            <select class="form-control" v-model="pair1">
                <option v-for="pair in pairs" :value="pair">{{ pair }}</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label>Получите</label>
            <select class="form-control" v-model="pair2">
                <option v-for="pair in pairs" :value="pair">{{ pair }}</option>
            </select>
        </div>

        <button class="btn btn-primary mt-3" @click="update">Применить</button>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                pair1: null,
                pair2: null,
                pairs: []
            }
        },
        methods: {
            update() {
                if (this.pair1 && this.pair2) {
                    this.$parent.pair1 = this.pair1;
                    this.$parent.pair2 = this.pair2;
                    this.$parent.updateRate();
                }
            }
        }
    }
</script>