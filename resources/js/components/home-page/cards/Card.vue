<template>
    <div class="panel panel-default card-view pa-0">
        <div class="panel-wrapper collapse in">
            <div class="panel-body pa-0">
                <div class="sm-data-box" :class="color">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                <span class="txt-light block counter">
                                    <span class="counter-anim">
                                        {{data}}
                                    </span>
                                </span>
                                <span class="weight-500 uppercase-font txt-light block">{{title}}</span>
                            </div>
                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                <i class="txt-light data-right-rep-icon" :class="icon" />
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
        name: "Card",

        props: ['color', 'icon', 'title', 'data'],
    }
</script>

<style scoped>

</style>
