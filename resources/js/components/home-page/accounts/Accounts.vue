<template>
    <div>
        <accounts-escort-trans v-if="second" />
        <accounts-general v-else/>
    </div>
</template>

<script>
    export default {
        name: "Accounts",

        props: ['sites'],

        computed: {
            second() {
                return this.$store.state.second;
            }
        },

        mounted() {
            this.$store.commit('setSites', this.sites);
        }
    }
</script>

<style scoped>

</style>
