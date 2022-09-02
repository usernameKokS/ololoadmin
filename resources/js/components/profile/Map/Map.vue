<template>
    <div>
        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 mb-15">
            <div id="spain"/>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 pull-right">
            <div class="panel panel-default card-view">
                <panel-heading :title="`Ciudades (${cities.site})`"/>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body row">
                        <div class="table-wrap sm-data-box-2">
                            <div class="table-responsive">
                                <table class="table top-countries mb-0">
                                    <tbody>
                                    <tr v-for="city of cities.cities">
                                        <td>
                                            <span class="country-name txt-dark weight-500">{{city.city}}</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="badge transparent-badge">{{city.count}}</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="badge transparent-badge">{{city.percent}} %</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Map",

        props: ['cities'],

        mounted() {
            $('#spain').vectorMap({
                map: 'es_mill',
                zoomButtons: false,
                focusOn: {
                    x: 1.7,
                    y: -1.7,
                    scale: 1.5,
                },
                series: {
                    regions: [{
                        scale: {
                            '1': '#d4e1db',
                            '2': '#FF69B4'
                        },
                        attribute: 'fill',
                        values: this.regions_data,
                    }]
                },
                onRegionTipShow: (e, el, code) => {
                    const region = this.regions.find(r => r.code === code).region;
                    const find = this.cities.cities.find(r => r.city.toUpperCase().includes(region));

                    if (find !== undefined){
                        el.html(`${el.html()} ${find.count}`);
                    }
                },
            });
        },

        computed: {
            regions(){
                return this.$store.state.regions;
            },

            regions_data(){
                const regions = this.regions;
                const cities = this.cities.cities;
                let data = {};
                regions.forEach(region => {
                    const region_code = region.code;
                    const region_name = region.region;

                    const find = cities.filter(i => i.city.toUpperCase().includes(region_name));

                    data[region_code] = find.length ? 2 : 1;
                });

                return data;
            }
        }
    }
</script>

<style scoped>
    #spain {
        width: 100%;
        height: 500px;
    }
</style>
