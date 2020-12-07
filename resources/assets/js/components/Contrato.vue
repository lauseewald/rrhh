<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Contrato
                        <button type="button" @click="abrirModal('contrato','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                    
                                    <option value="nombre">Nombre</option>
                                   
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarTabla(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarTabla(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Empleado</th>
                                    <th>Nombre</th>
                                    <th>Puesto</th>
                                    <th>Horas Laborales</th>
                                    <th>Salario</th>
                                    <th>Inicio Laboral</th>
                                    <th>Exitinción de Contrato</th>
                                    
                                    <th>Condición</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contrato in arrayContrato" :key="contrato.id">
                                   
                                    <td v-text="contrato.apellidoEmpleado+ ' ' + contrato.nombreEmpleado"></td>
                                    <td v-text="contrato.nombreContrato"></td>
                                    <td v-text="contrato.nombrePuesto"></td>
                                    <td v-text="contrato.cantidadHorasDiarias"></td>
                                    <td v-text="contrato.salario"></td>
                                    <td v-text="contrato.inicioLaboral"></td>
                                    <td v-text="contrato.finLaboral"></td>
                                 
                                    <td>
                                        <div v-if="contrato.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('contrato','actualizar',contrato)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="contrato.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarContrato(contrato.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarContrato(contrato.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-form" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Empleados (*)</label>
                                 <select class="form-control" v-model="idempleado">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="empleado in arrayEmpleado" :key="empleado.id" :value="empleado.id" v-text="empleado.apellido + ' ' + empleado.nombre"></option>
                                </select>   
                                    </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre (*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del contrato">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripcion (*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Descripcion del contrato">
                                        
                                    </div>
                                </div>
                                    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Puestos (*)</label>
                                <select class="form-control" v-model="idpuesto">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="puesto in arrayPuesto" :key="puesto.id" :value="puesto.id" v-text="puesto.nombre"></option>
                                </select>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Horas Laborales (*)</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="cantidadHorasDiarias" class="form-control" placeholder="Cantidad de horas laborales">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Salario (*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="salario" class="form-control" placeholder="Salario laboral">
                                        
                                    </div>
                                </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label >Fecha Inicio Laboral (*)</label>
                                        <input type="date" class="form-control" v-model="inicioLaboral" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label >Fecha final del contrato (*)</label>
                                        <input type="date" class="form-control" v-model="finLaboral" >
                                </div>
                            </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Contrato </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="contrato" class="form-control" placeholder="Contrato">
                                        
                                    </div>
                                </div>
                                
                               
                                <div v-show="errorComponente" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjForm" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarContrato()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarContrato()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
import toastr from 'toastr'; 
    export default {
        data (){
            return {
                contrato_id: 0,
                nombre : '',
                descripcion : '',
                arrayPuesto : [],
                arrayEmpleado : [],
                arrayContrato : [],
                cantidadHorasDiarias : 0,
                salario : 0.0,
                inicioLaboral : new Date(),
                finLaboral : new Date(),
                contrato : '',
                idpuesto : 0,
                idempleado : 0,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorComponente : 0,
                errorMostrarMsjForm : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarTabla (page,buscar,criterio){
                this.listarContrato(page,buscar,criterio);
            },
            listarContrato (page,buscar,criterio){
                let me=this;
                var url= '/contrato?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;

                    me.arrayContrato = respuesta.contratos.data;
                    me.pagination= respuesta.pagination;
                    console.log(response)
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, selectPuesto(){
                
                let me=this;
                //loading(true)
                
                var url= '/puesto/selectPuesto';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    //q: search
                    me.arrayPuesto=respuesta.puestos;
                    console.log('select Puesto');
                    //loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, selectEmpleado(){
                let me=this;
                //loading(true)
                var url= '/empleado/selectEmpleado';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    //q: search
                    me.arrayEmpleado=respuesta.empleados;
                    console.log('select Empleado');
                    //loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarTabla(page,buscar,criterio);
            },
            registrarContrato(){
                let me = this;
                if (this.validarForm()){
                    return;
                }
                console.log(this.nombre);
                console.log(this.idpuesto);
                console.log(this.idempleado);
                console.log(this.cantidadHorasDiarias);
                console.log(this.salario);
                console.log(this.inicioLaboral);
                console.log(this.finLaboral);
                console.log(this.contrato);
                axios.post('/contrato/registrar',{
                'nombre': this.nombre,
                'descripcion': this.descripcion,
                'idpuesto': this.idpuesto,
                'idempleado ': this.idempleado,
                'cantidadHorasDiarias ': this.cantidadHorasDiarias,
                'salario ': this.salario,
                'inicioLaboral ': this.inicioLaboral,
                'finLaboral ': this.finLaboral,
                'contrato ': this.contrato
                }).then(function (response) {
                    console.log(response);
                    me.cerrarModal();
                    me.listarTabla(1,'','nombre');
                    toastr.success('Se ha registrado el contrato', 'Registrado', {timeOut: 5000})
                }).catch(function (error) {
                    console.log(error);
                    toastr.error('Ha ocurrido un error', 'Error', {timeOut: 5000})
                });
            },
            actualizarContrato(){

                console.log('prueba');
               if (this.validarForm()){
                    return;
                }
                
                let me = this;
                axios.put('/contrato/actualizar',{
                'nombre': this.nombre,
                'descripcion': this.descripcion,
                'idpuesto': this.idpuesto,
                'idempleado ': this.idempleado,
                'cantidadHorasDiarias ': this.cantidadHorasDiarias,
                'salario ': this.salario,
                'inicioLaboral ': this.inicioLaboral,
                'finLaboral ': this.finLaboral,
                'contrato ': this.contrato,
                'id': this.contrato_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarTabla(1,'','nombre');
                    toastr.success('Se ha actualizado con exito', 'Actualizado', {timeOut: 5000})
                }).catch(function (error) {
                    console.log(error);
                    toastr.error('Ha ocurrido un error', 'Error', {timeOut: 5000})
                }); 
            },
            desactivarContrato(id){
               swal({
                title: 'Esta seguro de desactivar este Contrato?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/contrato/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarTabla(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El contrato se ha desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarContrato(id){
               swal({
                title: 'Esta seguro de activar este contrato?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/contrato/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarTabla(1,'','nombre');
                        swal(
                        'Activado!',
                        'El Contrato se ha activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            
            
            validarForm(){
                this.errorComponente=0;
                this.errorMostrarMsjForm =[];
                // if (!this.nombre) this.errorMostrarMsjForm.push("Debe ingresar el nombre del Contrato");
                // if (!this.cantidadHorasDiarias) this.errorMostrarMsjForm.push("Debe ingresar una cantidad de horas de trabajo");
                // if (!this.salario) this.errorMostrarMsjForm.push("Debe ingresar un salario mayor a 0.0");
                // if (!this.idpuesto) this.errorMostrarMsjForm.push("Debe seleccionar un puesto");
                // if (!this.idempleado) this.errorMostrarMsjForm.push("Debe seleccionar un empleado");
                // if (!this.inicioLaboral) this.errorMostrarMsjForm.push("Debe seleccionar una fecha inicial");
                // if (!this.finLaboral) this.errorMostrarMsjForm.push("Debe seleccionar una fecha final del contrato");
                // if (!this.fechaAlta) this.errorMostrarMsjEmpleado.push("La fecha de ingreso del empleado no puede estar vacía.");

                // if (this.inicioLaboral.getTime() > Date().getTime()) this.errorMostrarMsjForm.push("La fecha del contrato debe ser mayor a hoy");
                // if (this.finLaboral.getTime() > this.inicioLaboral.getTime()) this.errorMostrarMsjForm.push("La fecha de expirasión del contrato tiene que ser mayor al dia Inicial");
                if (this.errorMostrarMsjForm.length) this.errorComponente = 1;
                return this.errorComponente;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.idpuesto=0;
                this.idempleado=0;
                this.cantidadHorasDiarias=0;
                this.salario=0.0;
                this.inicioLaboral= new Date();
                this.finLaboral= new Date();
                this.contrato = '';
            },
            
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "contrato":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Contrato';
                                this.nombre='';
                                this.descripcion='';
                                this.idpuesto=0;
                                this.idempleado=0;
                                this.cantidadHorasDiarias=0;
                                this.salario=0.0;
                                this.inicioLaboral= new Date();
                                this.finLaboral= new Date();
                                this.contrato = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar contrato';
                                this.tipoAccion=2;

                                this.contrato_id=data['id'];
                                this.nombre = data['nombreContrato'];  
                                this.descripcion = data['descripcionContratos'];  
                                this.idpuesto=data['puesto_id'];
                                this.idempleado=data['empleado_id'];
                                this.cantidadHorasDiarias=data['cantidadHorasDiarias'];
                                this.salario=data['salario'];
                                this.inicioLaboral= data['inicioLaboral'];
                                this.finLaboral= data['finLaboral'];
                                this.contrato = data['contrato'];

                                break;
                            }
                        }
                    }
                }
            }
            
        },
        mounted() {
            this.listarTabla(1,this.buscar,this.criterio);
            this.selectPuesto();
            this.selectEmpleado();
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
