<template>
    <div class="panel panel-default card-view  pa-0">
        <div class="panel-wrapper collapse in">
            <div class="panel-body  pa-0">
                <div class="profile-box">
                    <div class="profile-cover-pic">
                        <div class="profile-image-overlay"/>
                    </div>
                    <div class="profile-info text-center">
                        <div class="profile-img-wrap">
                            <img class="inline-block mb-10" :src="profile.avatars[0]" alt="user"/>
                        </div>
                        <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-danger">{{profile.name}}</h5>
                        <h6 class="block capitalize-font pb-20">{{profile.email}}</h6>
                        <h6 class="block capitalize-font pb-20">{{profile.tel}}</h6>
                    </div>
                    <div class="social-info">
                        <div class="row mb-20">
                            <profile-counter title="Publicados" :count="profile.posts_count"/>
                            <profile-counter title="Tarifas" :count="profile.tariffs_count"/>
                            <profile-counter title="Total" :count="profile.tariffs_sum" :euro="true"/>
                            <profile-counter title="Publicados Portales" :count="profile.portals_count"/>
                            <profile-counter title="Total Pasion <br> * 0.20" :count="profile.auto_renovados_sum" :euro="true"/>
                            <profile-counter title="Autorenovados Pasion" :count="profile.auto_renovados"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Profile",

        props: ['profile']
    }
</script>

<style scoped>

</style>
