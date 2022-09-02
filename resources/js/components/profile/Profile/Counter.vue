<template>
    <div class="col-xs-4 text-center mb-15">
        <span class="counts block head-font">
            <span class="counter-anim">
                {{Math.floor(count)}}
            </span>
            <span v-if="euro">€</span>
        </span>
        <span class="counts-text block" v-html="title"/>
    </div>
</template>

<script>
    export default {
        name: "Counter.vue",

        props: ['title', 'count', 'euro']
    }
</script>

<style scoped>

</style>
