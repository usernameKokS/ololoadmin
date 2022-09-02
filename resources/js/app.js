window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.baseURL = '/api/';
import vSelect from "vue-select";
import JsonExcel from 'vue-json-excel';
import VueLazyload from 'vue-lazyload'

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyDN2hAA5L9opTbXIJuolUBu7F0_uoL6Tvo',
        libraries: 'places', // This is required if you use the Autocomplete plugin
        region: 'ES',
        language: 'es',
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)

        // // If you want to set the version, you can do so:
        v: '3.38'
    },

    // // If you intend to programmatically custom event listener code
    // // (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
    // // instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
    // // you might need to turn this on.
    // autobindAllEvents: false,

    // // If you want to manually install components, e.g.
    // // import {GmapMarker} from 'vue2-google-maps/src/components/marker'
    // // Vue.component('GmapMarker', GmapMarker)
    // // then disable the following:
    // installComponents: true,
})

import lodash from 'lodash'
import Notify from './components/Notify';

Vue.component('checkphone', require('./components/Checkphone.vue').default);
Vue.component('photo', require('./components/Photo.vue').default);
Vue.component('videoupload', require('./components/Videoupload.vue').default);
Vue.component('postcreate', require('./components/Postcreate.vue').default);

Vue.component('login', require('./components/login/Login').default);

Vue.component('card-stats', require('./components/home-page/cards/Cards').default);
    Vue.component('card', require('./components/home-page/cards/Card').default);

Vue.component('user-stats', require('./components/home-page/users/Users').default);
    Vue.component('user-stat', require('./components/home-page/users/Stat').default);

Vue.component('escort-trans', require('./components/home-page/escort-trans/EscortTrans').default);
    Vue.component('chart-label', require('./components/home-page/escort-trans/Label').default);

Vue.component('tariff', require('./components/home-page/tariff/Tariff').default);
    Vue.component('tariff-range', require('./components/home-page/tariff/Range').default);
    Vue.component('tariff-all-time', require('./components/home-page/tariff/AllTime').default);
    Vue.component('tariff-sum', require('./components/home-page/tariff/Sum').default);
    Vue.component('tariff-block', require('./components/home-page/tariff/Block').default);

Vue.component('accounts', require('./components/home-page/accounts/Accounts').default);
    Vue.component('accounts-general', require('./components/home-page/accounts/General').default);
    Vue.component('accounts-escort-trans', require('./components/home-page/accounts/EscortTrans').default);
    Vue.component('date-range-picker', require('./components/home-page/accounts/DateRangePicker').default);

Vue.component('ads-table', require('./components/home-page/ads/Ads').default);

Vue.component('comparision', require('./components/home-page/Comparison/Comparison').default);

Vue.component('panel-heading', require('./components/home-page/PanelHeading').default);

Vue.component('profile', require('./components/profile/Profile/Profile').default);
    Vue.component('profile-counter', require('./components/profile/Profile/Counter').default);

Vue.component('photos', require('./components/profile/Photos/Photos').default);

Vue.component('maps', require('./components/profile/Map/Map').default);

Vue.component('settings', require('./components/profile/Settings/Settings').default);

Vue.component('table-data', require('./components/profile/Table/Table').default);

Vue.component('parser-data', require('./components/profile/ParserLinks/Table').default);

Vue.component('forums', require('./components/profile/Forum/Forum').default);

Vue.component('posts', require('./components/profile/Posts/Posts').default);

Vue.component('filter-page', require('./components/filter/Filter').default);

Vue.component("v-select", vSelect);
Vue.component('downloadExcel', JsonExcel);

Vue.use(VueLazyload);

import store from './store'

const app = new Vue({
    el: '#app',
    store,
});
