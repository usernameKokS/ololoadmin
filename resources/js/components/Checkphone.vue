<template>
    <section>
        <div class="edit-phone" id="edit-phone">
            <div class="container">
                <div class="container container-two">
                    <div class="phone-area__wrap">
                        <div class="phone-area">
                            <div class="input-inline-wrap">
                                <div class="label-wrap">
                                    <span class="input-label">Teléfono:</span>
                                </div>
                                <form class="input-area__withbtn" @submit.prevent="sendphone">
                                    <input
                                        type="text"
                                        name="phone"
                                        class="input"
                                        placeholder=""
                                        v-model.trim="$v.phone.$model"
                                        :class="{ 'input-error':  $v.phone.$error }"
                                        v-mask="'###-###-###'"
                                        v-model="phone"
                                    />

                                    <div class="input-inline-wrap__btn" v-if="!phoneSuccess">
                                        <button type="submit" class="btn btn-normal btn_green-hover non-fixed-btn2"
                                                title="Enviar sms">
                                            <div style="padding-left: 14px !important; padding-top: 5px !important;">
                                                <img src="/img/sms.svg" alt="return" style="margin-top: 2px;"/>
                                                <span>enviar sms</span>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="phone-is-confirm" v-if="phoneSuccess">
                                        <img src="/img/icon-success.svg" />
                                        Número de teléfono verificado
                                    </div>
                                </form>
                            </div>
                            <div class="phone-area-improtant">
                                <div class="label-wrap disable-desk"></div>
                                <div>
                                    <span>Importante!</span>
                                    <p>Para publicar el anuncio, es necesario verificar el número de teléfono</p>
                                </div>
                            </div>
                        </div>
                        <div class="phone-confirm" v-if="!phoneSuccess">
                            <form class="input-inline-wrap" @submit.prevent="checkcode">
                                <div class="label-wrap">
                                    <img src="/img/arrow-pointing-to-right.svg" alt="svg"/>
                                    <span class="input-label">
                                        Introduce el codigó:
                                    </span>
                                </div>
                                <div class="input-area__withbtn">
                                    <input
                                        type="text"
                                        name="code"
                                        class="input"
                                        v-model="code"
                                        v-model.trim="$v.code.$model"
                                        :class="{ 'input-error':  $v.code.$error }"
                                    />
                                    <div class="input-inline-wrap__btn">
                                        <button type="submit" class="btn btn-normal btn_green-hover non-fixed-btn3"
                                                title="Confirmar">
                                            <div>
                                                <img src="/img/checkedpink.svg" alt="svg"/>
                                                <span>Confirmar</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import {alphaNum, maxLength, minLength, required} from "vuelidate/lib/validators";
    import Notify from "./Notify";

    export default {
        props: ["user", "post"],
        data() {
            return {
                phone: this.post.phone,
                code: "",
                submitStatus: null,
                post_id: this.post.id,
                phoneSuccess: false,
            };
        },
		watch: {
			phone: function(val){
				let phone = val.replaceAll('-', '');
				
				if(phone == this.post.phone)
					this.phoneSuccess = true;
				else
					this.phoneSuccess = false;
			}
		},
        computed: {
            firstNum(){
                const model = this.$v.phone.$model;
                return (model === null || model === "" || model === undefined) ? '' : model[0];
            }
        },
        validations: {
            phone: {
                required
            },
            code: {
                required,
                minLength: minLength(6),
                maxLength: maxLength(6),
                alphaNum
            }
        },
        created() {
            if (this.post.phone != null) {
                this.phoneSuccess = true;
            }
        },
        methods: {
            sendphone() {
                this.$v.phone.$touch();
                if (this.$v.phone.$invalid) {
                    this.submitStatus = "ERROR";
                } else {
                    this.submitStatus = "OK";

                    axios
                        .post("/phone/create", {
                            phone: this.phone,
                            post_id: this.post_id,
                        })
                        .then(response => {
                            this.$modal.show(
                                Notify,
                                {
                                    title: "Éxito",
                                    type: "success",
                                    porterrors: null,
                                    message: response.data.success
                                },
                                {
                                    width: 380,
                                    height: "auto"
                                }
                            );
                        })
                        .catch(error => {
                            if (error.response.status === 422) {
                                this.$modal.show(
                                    Notify,
                                    {
                                        title: "Algo no exitoso",
                                        type: "error",
                                        porterrors: error.response.data.errors
                                    },
                                    {
                                        width: 380,
                                        height: "auto"
                                    }
                                );
                            } else {
                                this.$modal.show(
                                    Notify,
                                    {
                                        title: "Algo no exitoso",
                                        type: "error",
                                        // porterrors: error.response.data.errors
                                        message: "Error, Try again later"
                                    },
                                    {
                                        width: 380,
                                        height: "auto"
                                    }
                                );
                            }
                        });
                }
            },
            checkcode() {
                this.$v.code.$touch();
                if (this.$v.code.$invalid) {
                    this.submitStatus = "ERROR";
                } else {
                    this.submitStatus = "OK";
                    axios
                        .post("/phone/check", {
                            code: this.code,
                            post_id: this.post.id
                        })
                        .then(response => {
                            this.phoneSuccess = true;
                            this.code = "";
                            // event.target.blur();
                            this.$nextTick(() => {
                                this.$v.code.$reset()
                            })
                            this.$modal.show(
                                Notify,
                                {
                                    title: "Éxito",
                                    type: "success",
                                    porterrors: null,
                                    message: response.data.success
                                },
                                {
                                    width: 380,
                                    height: "auto"
                                }
                            );
                        })
                        .catch(error => {
                            if (error.response.status === 422) {
                                this.$modal.show(
                                    Notify,
                                    {
                                        title: "Algo no exitoso",
                                        type: "error",
                                        porterrors: error.response.data.errors
                                    },
                                    {
                                        width: 380,
                                        height: "auto"
                                    }
                                );
                            }
                        });
                }
            }
        },
        mounted() {
            console.log("Component mounted. Loaded.");
        }
    };
</script>
<style>
.phone-is-confirm
{
    padding-left: 5px;
}

.phone-is-confirm img
{
    max-width: 24px;
    margin: 0 5px;
}
</style>
