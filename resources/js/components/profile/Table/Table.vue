<template>
    <div class="table-wrap">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                <tr>
                    <th>Site</th>
                    <th>Parser</th>
                    <th>Parser Count</th>
                    <th>Active</th>
                    <th>Inactive</th>
                    <th>Active Count</th>
                    <th>InActive Count</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="data of stats">
                    <th class="clickable"
                        @click="clickSite(data.site)"
                        :class="{'text-success': site === data.site}">
                            {{data.site}}
                    </th>
                    <th>{{data.parser ? '✅' : '❌'}}</th>
                    <th>{{data.parser_count}}</th>
                    <th>{{data.active}} %</th>
                    <th>{{data.inactive}} %</th>
                    <th>{{data.active_count}}</th>
                    <th>{{data.inactive_count}}</th>
                    <th>{{data.total}}</th>
                </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Site</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="link of table_links">
                        <th>{{link.site}}</th>
                        <th>
                            <a :href="link.link" target="_blank" class="text-primary">
                                {{link.link}}
                            </a>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Table",

        props: ['table'],

        data(){
            const {table, links} = this.table;

            return {
                stats: table,
                links,
                site: '',
            }
        },

        methods: {
            clickSite(site){
                this.site = this.site === site ? '' : site;
            }
        },

        computed: {
            table_links(){
                // If some site is clicked than show links of this site else, show all links
                return !this.site.length ? this.links : this.links.filter(l => l.site === this.site);
            }
        }
    }
</script>
