<template>
    <div class="panel-body sm-data-box-1">
        <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Total</span>
        <div class="cus-sat-stat weight-500 txt-success text-center mt-5">
            <span>{{value}}</span>
            <span>€</span>
        </div>
        <span class="uppercase-font weight-500 font-14 block text-center txt-dark mb-30">{{count}}</span>
        <slot/>
    </div>
</template>

<script>
    export default {
        name: "Sum",

        props: ['value', 'count'],
    }
</script>

<style scoped>

</style>
