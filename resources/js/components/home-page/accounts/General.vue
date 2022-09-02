<template>
    <div class="panel panel-default card-view">
        <date-range-picker/>
        <panel-heading title="Cuentas"/>
        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <div id="accounts_chart" class="morris-chart" style="height:293px;"></div>
                <ul class="flex-stat mt-40">
                    <li v-for="(site, key) of sites" :key="key" v-if="actualData !== false">
                        <span class="block" :style="{color: colors[key]}">
                            {{site}}
                        </span>
                        <span class="block txt-dark weight-500 font-18">
                            <span>
                                {{actualData[site]['active']}} / {{actualData[site]['inactive']}}
                            </span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "General",

        data() {
            return {
                actualData: false,
            }
        },

        mounted() {
            this.fetchData();
        },

        watch: {
            range() {
                this.fetchData();
            },
        },

        computed: {
            sites() {
                return this.$store.state.sites;
            },
            range() {
                return this.$store.state.range;
            },
            colors() {
                return this.$store.state.colors;
            },
            data() {
                return this.$store.state.data;
            }
        },

        methods: {
            fetchData() {
                let range = this.range.split(' - ');
                const start = moment(range[0], 'DD/MM/YYYY').format('X');
                const end = moment(range[1], 'DD/MM/YYYY').format('X');

                range = [start, end].join(' - ');

                axios.get('accounts', {params: {range}})
                    .then(r => {
                        const {stats, actualStats} = r.data.data;

                        this.$store.commit('setData', stats);
                        this.actualData = actualStats;

                        this.updateGraph();
                    });
            },
            updateGraph() {

                const data = [];

                this.data.map(d => {
                    const object = {date: moment(d.date).format("DD/MM/YY")};
                    this.sites.map(s => object[s] = d[s].active);
                    data.push(object)
                });

                $('#accounts_chart').empty();
                this.morris = Morris.Line({
                    element: 'accounts_chart',
                    data: data,
                    xkey: 'date',
                    ykeys: this.sites,
                    labels: this.sites,
                    pointSize: 2,
                    fillOpacity: 0,
                    lineWidth: 2,
                    pointStrokeColors: this.colors,
                    behaveLikeLine: true,
                    gridLineColor: '#878787',
                    hideHover: 'auto',
                    lineColors: this.colors,
                    resize: true,
                    redraw: true,
                    gridTextColor: '#878787',
                    gridTextFamily: "Roboto",
                    parseTime: false
                });
            }
        }
    }
</script>

<style scoped>

</style>
