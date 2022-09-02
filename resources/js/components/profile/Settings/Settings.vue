<template>
    <div class="panel-wrapper collapse in pl-15">
        <div class="panel-body">
            <div class="form-wrap">
                <div class="form-group mb-30">
                    <p>Pagado hasta: {{this.end_pay_format}}</p>
                    <div class="checkbox checkbox-primary">
                        <input id="checkbox1" type="checkbox" v-model="entity" :disabled="loading">
                        <label for="checkbox1">
                            Club
                        </label>
                    </div>
                    <div class="checkbox checkbox-danger">
                        <input id="checkbox2" type="checkbox" v-model="blocked" :disabled="loading">
                        <label for="checkbox2">
                            Bloquear
                        </label>
                    </div>
                    <button :disabled="loading" data-toggle="modal" data-target="#delete" class="btn btn-danger">
                        Eliminar cuenta
                    </button>
                    <button :disabled="loading" data-toggle="modal" data-target="#choose" class="btn btn-success">
                        Cambiar tarifa
                    </button>
                    <button :disabled="loading" data-toggle="modal" data-target="#continue" class="btn btn-primary">
                        Prolongar tarifa
                    </button>
                </div>
            </div>
        </div>

        <div id="choose" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="choose-label"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="choose-tariff-label">Cambiar tarifa</h5>
                    </div>
                    <div class="modal-body">
                        <h5 class="mb-15">Selecciona tarifa para el usuario</h5>
                        <div class="form-group mt-30 mb-30">
                            <label class="control-label mb-10 text-left" for="selectTariff">Selecciona la tarifa: </label>
                            <select v-model="changeTariff.tariff" id="selectTariff">
                                <option v-for="tariff of changeTariff.tariffs" :value="tariff">{{tariff}}</option>
                            </select>
                        </div>
                        <div class="form-group mt-30 mb-30">
                            <label class="control-label mb-10 text-left" for="selectDays">Días: </label>
                            <input type="number" v-model="changeTariff.days" id="selectDays">
                        </div>

                        <button class="btn btn-success" :disabled="loading" @click="change">Confirmar</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="closeChange" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div id="continue" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="continue-label"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="continue-label">Cambiar tarifa</h5>
                    </div>
                    <div class="modal-body">
                        <h5 class="mb-15">Selecciona tarifa para el usuario</h5>
                        <div class="form-group mt-30 mb-30">
                            <label class="control-label mb-10 text-left" for="selectDaysToContinue">Días: </label>
                            <input type="number" v-model="continueTariff.days" id="selectDaysToContinue">
                        </div>

                        <button class="btn btn-success" :disabled="loading" @click="continu">Confirmar</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="closeContinue" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div id="delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete-label"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="delete-label">¿Seguro que quieres eliminar esta cuenta?</h5>
                    </div>
                    <div class="modal-body">
                        <h6 class="mb-15">La cuenta se eliminará con todos los anuncios publicados.</h6>
                        <hr>
                        <button class="btn btn-danger btn-block" :disabled="loading" @click="deleteAccount">
                            Eliminar
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="closeDelete" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</template>

<script>
    export default {
        name: "Settings",
        props: ['settings', 'tel'],
        data: function () {
            const {entity, blocked, end_pay} = this.settings;

            return {
                entity, blocked, end_pay,
                loading: false,
                changeTariff: {
                    tariffs: ['silver', 'gold', 'diamond'],
                    tariff: 'silver',
                    days: 7,
                },
                continueTariff: {
                    days: 1,
                }
            };
        },

        methods: {
            update() {
                const {entity, blocked, tel} = this;
                this.loading = true;
                axios.post(`settings-update/${tel}`, {entity, blocked}).then(() => {
                    this.loading = false;
                })
            },

            change() {
                const {tariff, days} = this.changeTariff;
                const {tel} = this;
                this.loading = true;

                axios.post(`settings-change/${tel}`, {tariff, days})
                    .then((r) => {
                        this.loading = false;
                        this.end_pay = r.data.data;

                        $('#closeChange').click();
                    })
            },

            continu() {
                const {days} = this.continueTariff;
                const {tel} = this;
                this.loading = true;

                axios.post(`settings-continue/${tel}`, {days}).then(r => {
                    this.loading = false;
                    this.end_pay = r.data.data;

                    $('#closeContinue').click();
                });
            },

            deleteAccount() {
                const {tel} = this;
                this.loading = true;

                axios.post(`settings-delete/${tel}`)
                    .then(r => {
                        this.loading = false;
                        if (r.data.data) window.location.href = '/';
                    });
            }
        },

        watch: {
            entity() {
                this.update();
            },
            blocked() {
                this.update();
            }
        },

        computed: {
            end_pay_format() {
                return moment(this.end_pay).format('MMMM Do YYYY, h:mm:ss a');
            }
        },
    }
</script>

<style scoped>

</style>
