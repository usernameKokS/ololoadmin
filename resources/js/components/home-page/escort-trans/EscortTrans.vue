<template>
    <div class="panel panel-default card-view panel-refresh">
        <div class="refresh-container">
            <div class="la-anim-1"/>
        </div>
        <panel-heading title="Tipo de anuncios"/>
        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <div><canvas id="chart" height="191"/></div>

                <chart-label title="Escorts" :count="escort" :sum="sum" color="bg-yellow"/>
                <chart-label title="Travesti" :count="trans" :sum="sum" color="bg-blue"/>
                <chart-label title="Club Escorts" :count="escort_club" :sum="sum" color="bg-green"/>
                <chart-label title="Club Travestis" :count="trans_club" :sum="sum" color="bg-red"/>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EscortTrans",

        data() {
            return {
                escort: 0,
                trans: 0,
                escort_club: 0,
                trans_club: 0,
            }
        },

        created() {
            axios.get('escort-trans')
                .then(r => {
                    const {data} = r.data;

                    this.escort = data.escort;
                    this.trans = data.trans;
                    this.escort_club = data.escort_club;
                    this.trans_club = data.trans_club;

                    this.updateGraph();
                });
        },

        computed: {
            sum() {
                return this.escort + this.trans + this.escort_club + this.trans_club;
            }
        },

        methods: {
            updateGraph() {
                const context = document.getElementById("chart").getContext("2d");
                const data = {
                    labels: [
                        'Individual Escort',
                        'Individual Trans',
                        'Club Escort',
                        'Club Trans'
                    ],
                    datasets: [{
                        data: [this.escort, this.trans, this.escort_club, this.trans_club],
                        backgroundColor: ["#f2b700", "#0f4fa8", "#0aa274", "#dc0030"],
                    }]
                };

                new Chart(context, {
                    type: 'pie',
                    data: data,
                    options: {
                        animation: {
                            duration: 3000
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(33,33,33,1)',
                            cornerRadius: 0,
                            footerFontFamily: "'Roboto'"
                        },
                        elements: {
                            arc: {
                                borderWidth: 0
                            }
                        }
                    }
                });
            }
        }
    }
</script>
