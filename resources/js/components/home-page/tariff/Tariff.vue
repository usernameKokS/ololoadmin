<template>
    <div class="panel panel-default card-view">
        <div class="panel-wrapper collapse in">
            <tariff-sum :value="all.sum" :count="all.count">
                <ul class="flex-stat mt-5">
                    <tariff-block name="Silver" :value="silver.sum" :count="silver.count"/>
                    <tariff-block name="Gold" :value="gold.sum" :count="gold.count"/>
                    <tariff-block name="Diamond" :value="diamond.sum" :count="diamond.count"/>
                </ul>
            </tariff-sum>
            <tariff-range :range="range" :model="isAll" @changeRange="changeRange($event)"/>
            <tariff-all-time :model="isAll" @changeAllTime="changeIsAll($event)"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Tariff",

        data() {
            return {
                all: {
                    sum: 0,
                    count: 0,
                },
                silver: {
                    sum: 0,
                    count: 0,
                },
                gold: {
                    sum: 0,
                    count: 0,
                },
                diamond: {
                    sum: 0,
                    count: 0,
                },

                range: this.currentRange(),
                isAll: false,
            }
        },

        created() {
            this.fetchData();
        },

        methods: {
            fetchData() {
                let range = this.range.split(' - ');
                const start = moment(range[0], 'DD/MM/YYYY').format('X');
                const end = moment(range[1], 'DD/MM/YYYY').format('X');

                range = [start, end].join(' - ');
                const {isAll} = this;

                axios.get('tariff', {params: {range, isAll}})
                    .then(r => {
                        const {data} = r.data;

                        this.all.sum = data.all.sum.toFixed(2);
                        this.all.count = data.all.count;

                        this.silver.sum = data.silver.sum.toFixed(2);
                        this.silver.count = data.silver.count;

                        this.gold.sum = data.gold.sum.toFixed(2);
                        this.gold.count = data.gold.count;

                        this.diamond.sum = data.diamond.sum.toFixed(2);
                        this.diamond.count = data.diamond.count;
                    });
            },

            currentRange() {
                const s = moment().startOf('month').format('DD/MM/YYYY');
                const e = moment().endOf('month').format('DD/MM/YYYY');

                return `${s} - ${e}`;
            },

            changeRange(range) {
                this.range = range;
                this.fetchData();
            },

            changeIsAll(isAll) {
                this.isAll = isAll;
                this.fetchData();
            }
        }
    }
</script>

<style scoped>

</style>
