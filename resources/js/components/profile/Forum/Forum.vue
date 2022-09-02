<template>
    <div class="table-wrap">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Site</th>
                        <th>Link</th>
                    </tr>
                    <tr v-for="forum of forums">
                        <td>{{forum.site}}</td>
                        <td>
                            <a :href="forum.link" target="_blank" class="text-primary">
                                {{forum.link}}
                            </a>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Forum",

        props: ['forums'],
    }
</script>

<style scoped>

</style>
