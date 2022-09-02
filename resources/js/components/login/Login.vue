<template>
    <div class="table-struct full-width full-height">
        <div class="table-cell vertical-align-middle auth-form-wrap">
            <div class="auth-form  ml-auto mr-auto no-float">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="mb-30">
                            <h3 class="text-center txt-dark mb-10">Admin Panel</h3>
                        </div>
                        <div class="form-wrap">
                            <div class="form-group">
                                <label class="control-label mb-10" for="email">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email"
                                       v-model="email" required>
                            </div>
                            <div class="form-group">
                                <label class="pull-left control-label mb-10" for="password">Password</label>
                                <div class="clearfix"></div>
                                <input type="password" class="form-control" id="password" placeholder="Enter password"
                                       v-model="password" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-info btn-block" @click="submit()">Login</button>
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
        name: 'Login',

        data() {
            return {
                email: '',
                password: '',
            }
        },

        methods: {
            submit() {
                const {email, password} = this;

                axios.post('login', {email, password})
                    .then(r => r.data.message ? window.location.reload() : '');
            }
        }
    }
</script>
