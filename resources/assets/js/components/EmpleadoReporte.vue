<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="car-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Areas</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="areas">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Cantidad de Empleados por areas.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Puestos</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="puestos">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Empleados por puestos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
</template>
<script>
    export default {
        data (){
            return {
                varArea:null,
                charArea:null,
                areas:[],
                varCantidadArea:[],
                varNombreArea:[], 
                
                varVenta:null,
                charVenta:null,
                puestos:[],
                varCantidadPuesto:[],
                varNombrePuesto:[],
            }
        },
        methods : {
            getAreas(){
                let me=this;
                var url= '/empleado/reporte';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.areas = respuesta.empleadosArea;
                    //cargamos los datos del chart
                    me.loadArea();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getPuestos(){
                let me=this;
                var url= '/empleado/reporte';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.puestos = respuesta.empleadosPuesto;
                    //cargamos los datos del chart
                    me.loadPuestos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadArea(){
                let me=this;
                me.areas.map(function(x){
                    me.varNombreArea.push(x.nombre);
                    me.varCantidadArea.push(x.cantidad);
                });
                me.varArea=document.getElementById('areas').getContext('2d');

                me.charArea = new Chart(me.varArea, {
                    type: 'bar',
                    data: {
                        labels: me.varNombreArea,
                        datasets: [{
                            label: 'areas',
                            data: me.varCantidadArea,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },
            loadPuestos(){
                let me=this;
                me.puestos.map(function(x){
                    me.varNombrePuesto.push(x.nombre);
                    me.varCantidadPuesto.push(x.cantidad);
                });
                me.varVenta=document.getElementById('puestos').getContext('2d');

                me.charVenta = new Chart(me.varVenta, {
                    type: 'bar',
                    data: {
                        labels: me.varNombrePuesto,
                        datasets: [{
                            label: 'puestos',
                            data: me.varCantidadPuesto,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            }
        },
        mounted() {
            this.getAreas();
            this.getPuestos();
        }
    }
</script>
