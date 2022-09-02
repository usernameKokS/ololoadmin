<template>
    <div class="appmodal notify-modal">
        <div class="modal-container">
            <div class="modal-header modal-header-notify">
                <img v-if="!exitButton" :src="handleimg" alt="icon" class="handleimg" @click="$emit('close')"/>
                <h3>{{ title }}</h3>
                <img v-if="exitButton" src="/img/delete.svg" alt="icon" class="handleimg closebtn" @click="$emit('close')"/>
            </div>
        </div>
        <div class="faux-borders" style="width: 70%;"></div>
        <div class="modal-container">
            <div class="modal-body">
                <div class="notify-area">
                    <p v-for="(error, index) in porterrors" :key="index">{{ error[0] }}</p>
                    <div v-if="message" v-html="message"/>
                    <button class="btn btn-regular btn_green-hover btn-width-set" @click="$emit('close')">
                        <div>
                            <span v-if="confirm" @click="goConfirmLink">{{confirm}}</span>
                            <span v-else>Confirmar</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import videojs from 'video.js';

    export default {
        props: ["title", "type", "porterrors", 'message', 'confirm', 'confirmLink', 'exitButton'],
        data() {
            return {
                handleimg: "",
            };
        },
        mounted() {
            console.log("Modal open");
            if (this.type == "error") {
                this.handleimg = "/img/delete.svg";
            } else {
                this.handleimg = "/img/checked.svg";
            }
        },
        created() {
            document.body.style.overflow = "hidden";
        },
        beforeDestroy() {
            document.body.style.overflow = "auto";
        },

        methods: {
            goConfirmLink() {
                if (this.confirmLink !== null) {
                    location.href = this.confirmLink;
                }
            },
        }
    };
</script>

<style lang="scss" scoped>
    .modal-header-notify {
        justify-content: flex-start;
    }

    .handleimg {
        margin-right: 20px;
    }

    .notify-area {
        text-align: center;
        margin: 0 auto;

        p {
            padding-bottom: 6px;
        }

        button {
            margin: 30px auto 0px;
        }
    }

    .closebtn{
        margin-left: 31px !important;
        margin-right: 0px !important;
    }
</style>
