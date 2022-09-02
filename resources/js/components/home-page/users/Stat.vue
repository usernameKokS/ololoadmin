<template>
    <div>
        <span class="pull-left inline-block txt-dark">
            {{title}}
        </span>
        <span class="label pull-right" :class="color">
            {{amount}}
        </span>
        <div class="clearfix"/>
        <hr v-if="!disable_hr" class="light-grey-hr row mt-10 mb-10"/>
    </div>
</template>

<script>
    export default {
        name: "UserStat",

        props: ['title', 'amount', 'color', 'disable_hr']
    }
</script>

<style scoped>

</style>
