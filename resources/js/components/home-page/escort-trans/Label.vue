<template>
    <div>
        <hr class="light-grey-hr row mt-10 mb-15"/>
        <div class="label-chatrs">
            <div>
                <span class="clabels clabels-lg inline-block mr-10 pull-left" :class="color" />
                <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                <span class="block font-15 weight-500 mb-5">{{(count/sum * 100).toFixed(2)}}% {{title}}</span>
                <span class="block txt-grey">{{count}} Personas</span>
            </span>
                <div class="clearfix"/>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Label",

        props: ['title', 'count', 'sum', 'color'],
    }
</script>

<style scoped>

</style>
