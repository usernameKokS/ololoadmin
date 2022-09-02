<template>
    <div class="row">
        <div class="col-md-3 mt-15 mb-15 ml-15 mr-15" v-for="photo of photos">
            <img v-lazy="photo" alt="photo" class="img-responsive">
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Photos',

        props: ['photos'],
    }
</script>
