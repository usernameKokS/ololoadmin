<template>
    <div class="row" v-if="loaded">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <card title="Total anuncios" :data="all" color="bg-blue" icon="fa fa-users"/>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <card title="Anuncios activos" :data="active" color="bg-green" icon="fa fa-check-circle"/>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <card title="Anuncios inactivos" :data="nonActive" color="bg-red" icon="fa fa-crosshairs"/>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <card title="Usuarios sin pagar" :data="registeredButNotPaid" color="bg-yellow" icon="fa fa-money"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Cards",

        data() {
            return {
                all: 0,
                active: 0,
                nonActive: 0,
                registeredButNotPaid: 0,
                loaded: false,
            }
        },

        created() {
            axios.get('general-stats')
                .then(r => {
                    const {data} = r.data;

                    this.all = data.all;
                    this.active = data.active;
                    this.nonActive = data.nonActive;
                    this.registeredButNotPaid = data.registeredButNotPaid;

                    this.loaded = true;
                });
        }
    }
</script>

<style scoped>

</style>
