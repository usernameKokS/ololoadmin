<template>
    <div>
        <div class="pull-left">
            <div class="form-group mb-0">
                <label for="input" class="control-label mb-10 text-left">Fechas</label>
                <input class="form-control input-daterange-datepicker" id="input"/>
            </div>
        </div>
        <div class="pull-right">
            <div class="checkbox checkbox-primary">
                <input id="checkbox" type="checkbox" v-model="second">
                <label for="checkbox">
                    Estadísticas de portales
                </label>
            </div>
        </div>
        <div class="clearfix"/>
        <hr>
    </div>
</template>

<script>
    export default {
        name: "DateRangePicker",

        mounted() {
            $('.input-daterange-datepicker').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                },
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-info',
                cancelClass: 'btn-default',
            }).on('change', ({target}) => {
                this.range = target.value;
            }).val(this.range);
        },

        computed: {
            range: {
                get() {
                    return this.$store.state.range
                },
                set(newVal) {
                    this.$store.commit('setRange', newVal);
                }
            },

            second: {
                get() {
                    return this.$store.state.second
                },
                set(newVal) {
                    this.$store.commit('setSecond', newVal);
                }
            }
        },
    }
</script>

<style scoped>

</style>
