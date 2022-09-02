<template>
    <div class="panel panel-default card-view panel-refresh" v-if="data.all !== undefined">
        <panel-heading title="Estadística de publicación"/>
        <div class="panel-wrapper collapse in">
            <div class="panel-body row pa-0">
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Total web</th>
                                <th>Total publicado</th>
                                <th>% Total activo</th>
                                <th>% Total inactivo</th>
                                <th>Total activo cantidad</th>
                                <th>Total inactivo cantidad</th>
                            </tr>
                            <tr>
                                <td>{{data.all.count}}</td>
                                <td>{{data.all.all}}</td>
                                <td>{{data.all.total_active}} %</td>
                                <td>{{data.all.total_inactive}} %</td>
                                <td>{{data.all.total_active_count}}</td>
                                <td>{{data.all.total_inactive_count}}</td>
                            </tr>
                            <tr>
                                <th>Web</th>
                                <th>Total publicado</th>
                                <th>% Activo</th>
                                <th>% Inactivo</th>
                                <th>Activo cantidad</th>
                                <th>Inactivo cantidad</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(siteData, siteName) of data.sites">
                                <td class="txt-dark weight-500 text-left">{{siteName}}</td>
                                <td>{{siteData.total}}</td>
                                <td>{{siteData.total_active}} %</td>
                                <td>{{siteData.total_inactive}} %</td>
                                <td>{{siteData.total_active_count}}</td>
                                <td>{{siteData.total_inactive_count}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Ads",

        data() {
            return {
                data: [],
            };
        },

        mounted() {
            axios.get('ads-table').then(r => this.data = r.data.data)
        }
    }
</script>

<style scoped>
    table, tr, th, td, thead, tbody {
        text-align: center;
    }
</style>
