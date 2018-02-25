<template>
    <canvas id="chartLucroDiaMini" width="130" height="33"></canvas>
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
                this.$http.get('/niquelino/charts/getLucroHojeMini').then(
                    response=> {
                        t.data = response.body.lucros;
                        t.labels = response.body.horas;
                        t.montarGrafico();
                        t.hideLoading();
                    },
                    error=>{
                        console.log(error);
                    });

            },
            montarGrafico () {
                let t = this;
                let chartLucroDia = document.getElementById("chartLucroDiaMini").getContext('2d');

                let chart = new Chart(chartLucroDia, {
                    type: 'bar',
                    data: {
                        labels: t.labels,
                        datasets: [{
                            label: 'Lucro (R$)',
                            data: t.data,
                            pointBackgroundColor: '#263238',
                            borderColor: '#263238',
                            backgroundColor: '#263238',
                            borderWidth: 0.5,
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                display: false,
                                ticks: {
                                    beginAtZero:true
                                }
                            }],
                            xAxes: [{
                                display: false
                            }]
                        },
                        responsive: false,
                        tooltips: {
                            enabled: false
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
