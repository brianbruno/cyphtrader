<template>

    <div class="col col-lg-12">
        <div class="card text-dark border-blue-grey-darken-4">
            <div class="card-header border-blue-grey-darken-4 plataforma-titulo-cartao">Lucro por dia</div>
            <div class="card-body plataforma-corpo-cartao" id="divChartLucroDia">
                    <div v-show="!isLoading">
                        <canvas id="chartLucroHora"></canvas>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        mounted() {
            let t = this;
            t.carregarDados();
        },
        data () {
            return {
                isLoading: false,
                isLoadingHora: false,
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                data: [12, 19, 3, 5, 2, 3]
            }
        },
        methods: {
            showLoading(){
                this.isLoading = true;
            },
            hideLoading(){
                this.isLoading=false;
            },
            carregarDados () {
                let t = this;
                t.showLoading();
                this.$http.get('/niquelino/charts/getLucroPorDia').then(
                    response=> {
                        t.data = response.body.lucros;
                        t.labels = response.body.dias;
                        t.montarGrafico();
                        t.hideLoading();
                    },
                    error=>{
                        console.log(error);
                    });

            },
            montarGrafico () {
                let t = this;
                let chartLucroDia = document.getElementById("chartLucroHora").getContext('2d');

                let gradient = chartLucroDia.createLinearGradient(0, 0, 0, 450);

                gradient.addColorStop(0, 'rgba(77, 182, 172, 1)');
                gradient.addColorStop(0.5, 'rgba(224, 242, 241, 1)');
                gradient.addColorStop(1, 'rgba(179, 229, 252, 1)');

                let chart = new Chart(chartLucroDia, {
                    type: 'line',
                    data: {
                        labels: t.labels,
                        datasets: [{
                            label: 'Lucro',
                            data: t.data,
                            pointBackgroundColor: '#26a69a',
                            borderColor: '#004d40',
                            backgroundColor: gradient,
                            borderWidth: 1.6,
                            lineTension: 0.5,
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        },
                        responsive: true,
                        tooltips: {
                            enabled: true
                        },
                        legend: {
                            display: false,
                            position: "bottom",
                            labels: {
                                fontColor: '#004d40',
                                fontSize: 12,
                            }
                        }
                    }
                });
            }
        },
    }
</script>
