<template>
    <div class="panel panel-default card-view">
        <panel-heading title="Comparación"/>
        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <div id="comparison" class="morris-chart"/>
                <ul class="flex-stat mt-40">
                    <li>
                        <span class="block">
                            AlmejaRosa
                        </span>
                        <span class="block txt-dark weight-500 font-18">
                            <span class="text-success">{{data.ae}}</span> / <span class="text-danger">{{data.at}}</span>
                        </span>
                    </li>

                    <li>
                        <span class="block">
                            Portals
                        </span>
                        <span class="block txt-dark weight-500 font-18">
                            <span class="text-success">{{data.pe}}</span> / <span class="text-danger">{{data.pt}}</span>
                        </span>
                    </li>

                    <li>
                        <span class="block">
                            Comparación
                        </span>
                        <span class="block txt-dark weight-500 font-18">
                            <span class="text-success">{{comparisionEscort}} %</span> / <span class="text-danger">{{comparisionTrans}} %</span>
                        </span>
                    </li>
                </ul>

                <div class="label-chatrs mt-30">
                    <div class="inline-block">
                        <span class="clabels inline-block bg-green mr-5"/>
                        <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Escorts</span>
                    </div>
                    <div class="inline-block mr-15">
                        <span class="clabels inline-block bg-red mr-5"/>
                        <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Travesti</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Comparison",

        data() {
            return {
                data: false,
            }
        },

        methods: {
            updateGraph() {
                const {ae, at, pe, pt} = this.data;

                const aep = Math.floor((ae / (ae + at)) * 10000) / 100;
                const atp = Math.floor((at / (ae + at)) * 10000) / 100;

                const pep = Math.floor((pe / (pe + pt)) * 10000) / 100;
                const ptp = Math.floor((pt / (pe + pt)) * 10000) / 100;

                Morris.Bar({
                    element: 'comparison',
                    data: [
                        {
                            where: 'Almejarosa',
                            escort: aep,
                            trans: atp,
                        },
                        {
                            where: 'Portals',
                            escort: pep,
                            trans: ptp,
                        }
                    ],
                    xkey: 'where',
                    ykeys: ['escort', 'trans'],
                    labels: ['Escort %', 'Trans %',],
                    barColors: ['#0aa274', '#dc0030'],
                    hideHover: 'auto',
                    gridLineColor: '#878787',
                    resize: true,
                    gridTextColor: '#878787',
                    gridTextFamily: "Roboto"
                });
            }
        },

        mounted() {
            axios.get('comparison').then(r => {
                this.data = r.data.data;
                this.updateGraph();
            });
        },

        computed: {
            comparisionEscort() {
                const {ae, pe} = this.data;
                return Math.floor(ae / pe * 100 * 100) / 100;
            },

            comparisionTrans() {
                const {at, pt} = this.data;
                return Math.floor(at / pt * 100 * 100) / 100;
            }
        }
    }
</script>
