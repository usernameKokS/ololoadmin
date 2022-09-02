<template>
    <div class="mb-5">
        <div class="form-group mb-0">
            <label for="input" class="control-label mb-10 text-left">
                Fecha
            </label>
            <input class="form-control range" id="input" :disabled="model"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DateRangePicker",

        props: ['range', 'model'],

        mounted() {
            $('.range').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                },
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-info',
                cancelClass: 'btn-default',
            }).on('change', ({target}) => {
                this.$emit('changeRange', target.value);
            }).val(this.range);
        },
    }
</script>

<style scoped>

</style>
