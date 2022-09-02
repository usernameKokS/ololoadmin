<template>
    <div class="panel panel-default card-view">
        <date-range-picker/>
        <panel-heading title="Accounts"/>

        <div class="form-group">
            <select class="form-control" v-model="site">
                <option v-for="site of sites" :value="site">{{site}}</option>
            </select>
        </div>

        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <div id="accounts_chart" class="morris-chart" style="height:293px;"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="checkbox checkbox-primary">
                    <input id="active_escort" type="checkbox" v-model="types.active_escort">
                    <label for="active_escort">
                        {{labels.active_escort}}
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox checkbox-primary">
                    <input id="inactive_escort" type="checkbox" v-model="types.inactive_escort">
                    <label for="inactive_escort">
                        {{labels.inactive_escort}}
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox checkbox-primary">
                    <input id="active_trans" type="checkbox" v-model="types.active_trans">
                    <label for="active_trans">
                        {{labels.active_trans}}
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox checkbox-primary">
                    <input id="inactive_trans" type="checkbox" v-model="types.inactive_trans">
                    <label for="inactive_trans">
                        {{labels.inactive_trans}}
                    </label>
                </div>
            </div>
        </div>

        <ul class="flex-stat mt-40 mb-20">
            <li v-if="actualStatsTotal !== []">
                <span class="block">
                    Total Escort
                </span>
                <span class="block txt-dark weight-500 font-18">
                    <span>
                        {{actualStatsTotal.portals_escort_active}} / {{actualStatsTotal.portals_escort_inactive}}
                    </span>
                </span>
            </li>

            <li v-if="actualStatsTotal !== []">
                <span class="block">
                    Total Trans
                </span>
                <span class="block txt-dark weight-500 font-18">
                    <span>
                        {{actualStatsTotal.portals_trans_active}} / {{actualStatsTotal.portals_trans_inactive}}
                    </span>
                </span>
            </li>

            <li v-if="actualStats['pasiondb'] !== undefined">
                <span class="block">
                    {{site}} Escorts
                </span>
                <span class="block txt-dark weight-500 font-18">
                    <span>
                        {{actualStats[site]['active_escort']}} / {{actualStats[site]['inactive_escort']}}
                    </span>
                </span>
            </li>

            <li v-if="actualStats['pasiondb'] !== undefined">
                <span class="block">
                    {{site}} Travesti
                </span>
                <span class="block txt-dark weight-500 font-18">
                    <span>
                        {{actualStats[site]['active_trans']}} / {{actualStats[site]['inactive_trans']}}
                    </span>
                </span>
            </li>

            <li v-if="actualStats['pasiondb'] !== undefined && site === 'pasiondb'">
                <span class="block">
                    Passion Masajes
                </span>
                <span class="block txt-dark weight-500 font-18">
                    <span>
                        {{actualStats[site]['active_massage']}} / {{actualStats[site]['inactive_massage']}}
                    </span>
                </span>
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        name: "EscortTrans",

        data() {
            return {
                site: 'pasiondb',
                actualStats: [],
                actualStatsTotal: [],
                colors: {
                    active_escort: '#f2b701',
                    inactive_escort: '#b10058',
                    active_trans: '#0f4fa8',
                    inactive_trans: '#47f153',
                },
                labels: {
                    active_escort: 'Escorts activo',
                    inactive_escort: 'Escorts inactivo',
                    active_trans: 'Travesti activo',
                    inactive_trans: 'Travesti inactivo',
                },
                types: {
                    active_escort: true,
                    inactive_escort: false,
                    active_trans: false,
                    inactive_trans: false,
                }
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
                        const {stats, actualStats, actualStatsTotal} = r.data.data;

                        this.actualStatsTotal = actualStatsTotal;
                        this.actualStats = actualStats;

                        this.$store.commit('setData', stats);

                        this.updateGraph();
                    });
            },
            updateGraph() {
                const data = [];

                this.data.map(d => {
                    // Formatting date
                    const object = {date: moment(d.date).format("DD/MM/YY")};

                    // Adding data of selected checkboxes
                    this.activeTypes.map(type => object[type] = d[this.site][type]);

                    // Pushing data to main data
                    data.push(object);
                });

                $('#accounts_chart').empty();

                Morris.Line({
                    element: 'accounts_chart',
                    data: data,
                    xkey: 'date',
                    ykeys: this.activeTypes,
                    labels: this.activeLabels,
                    pointSize: 2,
                    fillOpacity: 0,
                    lineWidth: 2,
                    pointStrokeColors: this.activeColors,
                    behaveLikeLine: true,
                    gridLineColor: '#878787',
                    hideHover: 'auto',
                    lineColors: this.activeColors,
                    resize: true,
                    redraw: false,
                    gridTextColor: '#878787',
                    gridTextFamily: "Roboto",
                    parseTime: false
                });
            }
        },

        watch: {
            range() {
                this.fetchData();
            },

            types: {
                deep: true,
                handler: function () {
                    this.updateGraph();
                },
            },

            site: function () {
                this.updateGraph();
            }
        },

        computed: {
            sites() {
                return this.$store.state.sites;
            },
            range() {
                return this.$store.state.range;
            },
            data() {
                return this.$store.state.data;
            },
            actualData() {
                return this.$store.state.actualData;
            },
            activeTypes() {
                return Object.keys(this.types).filter(t => this.types[t]);
            },
            activeLabels() {
                return this.activeTypes.map(t => this.labels[t])
            },
            activeColors() {
                return this.activeTypes.map(t => this.colors[t])
            }
        },

        mounted() {
            this.fetchData();
        },
    }
</script>

<style scoped>

</style>
