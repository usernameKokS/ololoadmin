<template>
    <div>
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-xs-12 col-md-3 mb-20">
                            <v-select :options="sites" :clearable="false" v-model="site" :class="{'disabled': loading}"/>
                        </div>

                        <div class="col-xs-12 col-md-3 mb-20">
                            <v-select :options="cities" :clearable="false" v-model="city" :class="{'disabled': loading}"/>
                        </div>

                        <div class="col-xs-12 col-md-2 mb-20" v-if="site === 'pasiondb'">
                            <div class="checkbox">
                                <input id="auto_renovados" type="checkbox" v-model="auto_renovados" :disabled="loading">
                                <label for="auto_renovados">Filtrar por Autorenovados</label>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4 mb-20">

                            <div class="row">
                                <div class="col-xs-12 col-md-3 mr-30 mb-10">
                                    <download-excel :data="dataForExcel" :name="nameOfFile">
                                        <button class="btn btn-success btn-sm" :disabled="loading">Descargar Excel</button>
                                    </download-excel>
                                </div>

                                <div class="col-xs-12 col-md-3">
                                    <a href="/storage/excel/unique-numbers.xlsx" target="_blank">
                                        <button class="btn btn-success btn-sm">Descargar teléfonos únicos</button>
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6" v-if="table.length">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Telefono</th>
                                            <th>Cantidad</th>
                                            <th>Auto renovados</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) of table" :key="index">
                                            <td>
                                                {{index+1}}
                                            </td>
                                            <td class="clickable"
                                                @click="openItem(item.telephone)"
                                                :class="{'text-success': telephone === item.telephone}">
                                                {{item.telephone}}
                                            </td>
                                            <td>
                                                {{item.links_count}}
                                            </td>
                                            <td>
                                                {{item.auto_renovados}}
                                            </td>
                                            <td>
                                                <a :href="`/profile/${item.telephone}`" target="_blank" class="text-primary">
                                                    🔎
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6" v-if="links.length">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                        <tr>
                                            <th>Links</th>
                                            <th>Auto renovados</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) of links" :key="index">
                                            <th>
                                                <a :href="item.link" target="_blank" class="text-primary">
                                                    {{item.link}}
                                                </a>
                                            </th>
                                            <th>
                                                {{item.auto_renovados}}
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['sites', '_cities'],

        data() {
            return {
                site: 'pasiondb',
                city: 'Todos',
                cities: this._cities,
                loading: false,
                table: [],
                links: [],
                telephone: '',
                auto_renovados: false,
            }
        },

        methods: {
            getCities() {
                const {site} = this;
                this.loading = true;
                this.table = [];
                this.links = [];
                axios.get(`filter/cities/${site}`)
                    .then(r => {
                        this.loading = false;
                        this.city = 'Todos';
                        this.cities = r.data.data;
                        this.getTable();
                    });
            },

            getTable() {
                const {site, city} = this;
                this.loading = true;
                this.table = [];
                this.links = [];
                axios.get(`filter/table/${site}/${city}`)
                    .then(r => {
                        this.loading = false;
                        this.table = r.data.data;

                        if (this.auto_renovados === true && this.site === 'pasiondb') this.sortByAutorenovados();
                    })
            },

            openItem(telephone) {
                if (this.telephone === telephone) {
                    this.telephone = '';
                    this.links = [];
                    return false;
                }
                this.telephone = telephone;
                this.links = this.table.find(i => i.telephone === telephone).links;
            },

            sortByAutorenovados() {
                const {auto_renovados} = this;
                this.table = auto_renovados ?
                    this.table.sort((a, b) => parseInt(b.auto_renovados) - parseInt(a.auto_renovados)) :
                    this.table.sort((a, b) => parseInt(b.links_count) - parseInt(a.links_count));
            },
        },

        watch: {
            site() {
                this.getCities();
            },

            city() {
                this.getTable();
            },

            auto_renovados() {
                this.sortByAutorenovados();
            }
        },

        computed: {
            dataForExcel() {
                const data = [];
                this.table.forEach(item => {
                    const object = {
                        "Telephone": item.telephone,
                        "Links count": item.links_count,
                        "Auto renovados": item.auto_renovados
                    };

                    item.links.forEach((link, index) => {
                        const column = `Link ${index + 1}`;
                        object[column] = link.link
                    });

                    data.push(object);
                });

                return data;
            },

            nameOfFile() {
                return `${this.site}.${this.city}.xls`;
            }
        },

        created() {
            // this.getTable();
        },
    }
</script>

<style scoped>
    .disabled {
        pointer-events: none;
        color: #bfcbd9;
        cursor: not-allowed;
        background-image: none;
        background-color: #eef1f6;
        border-color: #d1dbe5;
    }
</style>
