<template>
    <div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th/>
                        <th/>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Tel.</th>
                        <th>Edad</th>
                        <th>Eliminado</th>
                        <th>Publicado</th>
                        <th>Pago Aut.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(post, index) of posts">
                        <td><img :src="post.main_avatar" alt="Avatar" style="width: 10%;"></td>
                        <td @click="clickEdit(index)">✏️</td>
                        <td>{{post.name}}</td>
                        <td>{{post.category}}</td>
                        <td v-if="post.phone !== null" class="clickable" @click="clickPhone(post.phone)">{{post.phone}}</td><td v-else>❌</td>
                        <td>{{post.age}}</td>
                        <td>{{post.archive ? 'Yes' : 'No'}}</td>
                        <td>{{post.publish ? '✅' : '❌'}}</td>
                        <td>{{post.autopay ? '✅' : '❌'}}</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="editModalLabel">Edit Post</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label mb-10 text-left">Phone</label>
                            <input type="text" class="form-control" v-model="form.phone">
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left">Introduce tu ciudad</label>
                            <v-select :options="placesOption" v-model="form.place"/>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Provincia: </label>
                                    <v-select :options="provincesOption" v-model="form.province"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Población: </label>
                                    <v-select :options="townsOption" v-model="form.town"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Zona: </label>
                                    <input type="text" v-model="form.zona">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left">Categoría:</label>
                            <v-select :options="categories" v-model="form.category"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left">Título: </label>
                            <input type="text" class="form-control" v-model="form.title">
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left">Texto: </label>
                            <textarea class="form-control" v-model="form.text"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 text-left">Nombre: </label>
                            <input class="form-control" type="text" v-model="form.name">
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" :checked="form.whatsapp">
                            <label>Whatsapp</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" @click="save">Save</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        name: "Posts",

        props: ['posts', 'places', 'categories'],

        data() {
            return {
                edit: 0,
                form: {
                    phone: '',
                    place: '',
                    province: '',
                    town: '',
                    zona: '',
                    category: '',
                    title: '',
                    text: '',
                    name: '',
                    whatsapp: false,
                }
            }
        },

        methods: {
            save() {
                const {form} = this;
                const phone = this.posts[this.edit].phone;
                axios.post('profile-save/' + phone, {form})
                    .then(() => {
                        $('#editModal').modal('hide');
                        window.location.reload();
                    });
            },

            clickPhone(phone) {
                window.location.href = '/profile/' + phone;
            },

            clickEdit(index) {
                this.edit = index;
                $('#editModal').modal('show');

                this.form.phone = this.posts[index].phone;
                this.form.place = this.posts[index].place;
                this.form.province = this.posts[index].province;
                this.form.town = this.posts[index].town;
                this.form.category = this.posts[index].category;
                this.form.title = this.posts[index].title;
                this.form.text = this.posts[index].text;
                this.form.name = this.posts[index].name;
                this.form.whatsapp = this.posts[index].whatsapp;
            }
        },

        computed: {
            placesOption() {
                return this.places.map(p => p.string);
            },

            provincesOption() {
                return [this.form.place.split(', ')[0]]
            },

            townsOption() {
                const places = this.places.filter(p => p.province === this.form.province);
                return places.map(p => p.town);
            }
        },

        watch: {
            'form.place': function(newVal){
                const newPlace = newVal.split(', ');
                this.form.province = newPlace[0];
                this.form.town = newPlace[1];
            }
        }
    }
</script>
