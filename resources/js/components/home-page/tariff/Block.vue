<template>
    <li>
        <span class="block">{{name}}</span>
        <span class="block txt-dark weight-500 font-15">{{value}} €</span>
        <span class="block">{{count}}</span>
    </li>
</template>

<script>
    export default {
        name: "Block",
        props: ['name', 'value', 'count']
    }
</script>

<style scoped>

</style>
