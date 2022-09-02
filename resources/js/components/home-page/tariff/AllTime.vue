<template>
    <div class="checkbox checkbox-primary mb-15">
        <input id="checkbox" type="checkbox" v-model="model">
        <label for="checkbox">
            Тоtal Tarifas Almeja Rosa
        </label>
    </div>
</template>

<script>
    export default {
        name: 'AllTime',
        props: ['model'],

        watch: {
            model(newVal) {
                this.$emit('changeAllTime', newVal);
            }
        }
    }
</script>
