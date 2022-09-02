<template>
    <div class="panel panel-default card-view" v-if="loaded">
        <panel-heading title="Estadísticas de usuarios"/>
        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <div>
                    <user-stat title="Teléfono verificado anuncio no pagado" :amount="phoneVerifiedButNotPaid" color="label-warning"/>
                    <user-stat title="Total usuarios con tarifa comprada" :amount="boughtAnyTariff" color="label-danger"/>
                    <user-stat title="Total usuarios con tarifa prolongada" :amount="tariffContinued" color="label-success"/>
                    <user-stat title="Total usuarios con tarifa cambiada" :amount="tariffChanged" color="label-primary" :disable_hr="true"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserStats",

        data() {
            return {
                phoneVerifiedButNotPaid: 0,
                boughtAnyTariff: 0,
                tariffContinued: 0,
                tariffChanged: 0,

                loaded: false,
            }
        },

        created() {
            axios.get('user-stats')
                .then(r => {
                    const {data} = r.data;

                    this.phoneVerifiedButNotPaid = data.phoneVerifiedButNotPaid;
                    this.boughtAnyTariff = data.boughtAnyTariff;
                    this.tariffContinued = data.tariffContinued;
                    this.tariffChanged = data.tariffChanged;

                    this.loaded = true;
                });
        },
    }
</script>

<style scoped>

</style>
