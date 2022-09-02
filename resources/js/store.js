import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const s = moment().startOf('month').format('DD/MM/YYYY');
const e = moment().endOf('month').format('DD/MM/YYYY');

const range = `${s} - ${e}`;

const regions = [
    {
        region: 'NAVARRA',
        code: 'ES-NA',
    },
    {
        region: 'BARCELONA',
        code: 'ES-B',
    },
    {
        region: 'CASTELLON',
        code: 'ES-CS',
    },
    {
        region: 'ZAMORA',
        code: 'ES-ZA',
    },
    {
        region: 'ASTURIAS',
        code: 'ES-O',
    },
    {
        region: 'OURENSE',
        code: 'ES-OR',
    },
    {
        region: 'MADRID',
        code: 'ES-M',
    },
    {
        region: 'LLEIDA',
        code: 'ES-L',
    },
    {
        region: 'JAEN',
        code: 'ES-J',
    },
    {
        region: 'HUELVA',
        code: 'ES-H',
    },
    {
        region: 'CUENCA',
        code: 'ES-CU',
    },
    {
        region: 'TARRAGONA',
        code: 'ES-T',
    },
    {
        region: 'LA_CORUNA',
        code: 'ES-C',
    },
    {
        region: 'AVILA',
        code: 'ES-AV'
    },
    {
        region: 'ALICANTE',
        code: 'ES-A'
    },
    {
        region: 'CIUDAD_REAL',
        code: 'ES-CR'
    },
    {
        region: 'CORDOBA',
        code: 'ES-CO'
    },
    {
        region: 'VALLADOLID',
        code: 'ES-VA'
    },
    {
        region: 'TENERIFE',
        code: 'ES-TF'
    },
    {
        region: 'ZARAGOZA',
        code: 'ES-Z'
    },
    {
        region: 'MALAGA',
        code: 'ES-MA'
    },
    {
        region: 'ALMERIA',
        code: 'ES-AL'
    },
    {
        region: 'CEUTA',
        code: 'ES-CE'
    },
    {
        region: 'BALEARES',
        code: 'ES-PM'
    },
    {
        region: 'ALAVA',
        code: 'ES-VI'
    },
    {
        region: 'CANTABRIA',
        code: 'ES-S'
    },
    {
        region: 'TERUEL',
        code: 'ES-TE'
    },
    {
        region: 'CACERES',
        code: 'ES-CC'
    },
    {
        region: 'PALENCIA',
        code: 'ES-P'
    },
    {
        region: 'PONTEVEDRA',
        code: 'ES-PO'
    },
    {
        region: 'LAS_PALMAS',
        code: 'ES-GC'
    },
    {
        region: 'GIRONA',
        code: 'ES-GI'
    },
    {
        region: 'TOLEDO',
        code: 'ES-TO'
    },
    {
        region: 'MURCIA',
        code: 'ES-MU'
    },
    {
        region: 'GRANADA',
        code: 'ES-GR'
    },
    {
        region: 'GUADALAJARA',
        code: 'ES-GU'
    },
    {
        region: 'ALBACETE',
        code: 'ES-AB'
    },
    {
        region: 'SORIA',
        code: 'ES-SO'
    },
    {
        region: 'MELILLA',
        code: 'ES-ML'
    },
    {
        region: 'LUGO',
        code: 'ES-LU'
    },
    {
        region: 'SEVILLA',
        code: 'ES-SE'
    },
    {
        region: 'CADIZ',
        code: 'ES-CA'
    },
    {
        region: 'SEGOVIA',
        code: 'ES-SG'
    },
    {
        region: 'BURGOS',
        code: 'ES-BU'
    },
    {
        region: 'SALAMANCA',
        code: 'ES-SA'
    },
    {
        region: 'VALENCIA',
        code: 'ES-V'
    },
    {
        region: 'LEON',
        code: 'ES-LE'
    },
    {
        region: 'Bizkaia',
        code: 'ES-BI'
    },
    {
        region: 'HUESCA',
        code: 'ES-HU'
    },
    {
        region: 'LA_RIOJA',
        code: 'ES-LO'
    },
    {
        region: 'GUIPUZCOA',
        code: 'ES-SS'
    },
    {
        region: 'BADAJOZ',
        code: 'ES-BA'
    },
];

export default new Vuex.Store({
    state: {
        sites: [],
        range,
        regions,
        colors: ['#af43f9', '#9ffa67', '#f6f407', '#a0e4e0', '#b4e5b9', '#0306fa', '#cc9a74', '#313ca1', '#827c83'],
        data: [],
        second: false,
    },

    mutations: {
        setSites(context, payload) {
            context.sites = payload;
        },
        setRange(context, payload) {
            context.range = payload;
        },
        setData(context, payload) {
            context.data = payload;
        },
        setSecond(context, payload){
            context.second = payload;
        }
    }
})
