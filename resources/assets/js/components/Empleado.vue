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
                        <i class="fa fa-align-justify"></i> Empleados
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">  
                                        <option value="nombre">Nombre</option>
                                        <option value="apellido">Apellido</option>
                                        <option value="cuil">Cuil</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEmpleado(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarEmpleado(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Cuil</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Dirección</th>
                                        <th>Fecha de Ingreso</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="empleado in arrayEmpleado" :key="empleado.id">
                                       <td v-text="empleado.cuil"></td>
                                    <td v-text="empleado.nombre"></td>
                                    <td v-text="empleado.apellido"></td>
                                    <td v-text="empleado.direccion"></td>
                                    <td v-text="empleado.fechaAlta"> </td>
                                    <td>
                                        <div v-if="empleado.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" @click="modificarEmpleado(empleado)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="empleado.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarEmpleado(empleado.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarEmpleado(empleado.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
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
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <!-- <div class="form-group">
                                    <label for="">Prueba(*)</label>
                                    <v-select
                                        :on-search="listarIncidencia"
                                        label="nombre"
                                        :options="arrayIncidencia"
                                        placeholder="Buscar Incidencias..."
                                        :onChange="getDatosIncidencia"                                        
                                    >
                                    </v-select>
                                </div> -->
                            </div>
                            <div  class="col-md-9">
                             <label>Incidencia</label>
                                <select class="form-control" v-model="idincidencia">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="incidencia in arrayIncidencia" :key="incidencia.id" :value="incidencia.id" v-text="incidencia.nombre"></option>
                                </select>                                        
                            </div>
                            <div class="col-md-6">
                                <label for=""><strong>Nombre (*)</strong></label>
                                <input type="text" class="form-control" v-model="nombre">
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Apellido (*)</label>
                                    <input type="text" class="form-control" v-model="apellido" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cuil (*)</label>
                                    <input type="text" id="numero" @keyup="valida()" v-model="cuil" class="form-control form-control-sm" maxlength="11">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dirección (*)</label>
                                    <input type="text" class="form-control" v-model="direccion" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label >Fecha de Nacimiento (*)</label>
                                        <input type="date" class="form-control" v-model="fechaNacimiento" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Fecha de de Ingreso (*)</label>
                                        <input type="date" class="form-control" v-model="fechaAlta"   >
                                </div>    
                            </div>
                                <div class="col-md-4">
                                <div class="form-group">
                                    <label>Curriculum (*)</label>
                                    <input type="text" class="form-control" v-model="curriculum" >
                                </div>
                                </div>
                            <div  class="col-md-9">
                             <label>Competencias</label>
                                <select class="form-control"  v-model="competenciasId" multiple>
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="competencia in arrayCompetencias" :key="competencia.id" :value="competencia.id" v-text="competencia.nombre"></option>
                                </select>                                        
                            </div>
                                 <!-- <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="data" form action="/data" method="POST" enctype="multipart/form-data">Curriculum (*) </label>
                                        <input type="file" @change="getImage" id="data" name="data" >            
                                    </div>
                                </div> -->
                            
                            <div class="col-md-12">
                                <div v-show="errorEmpleado" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEmpleado" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button"  v-if="modificar==0"  class="btn btn-primary" @click="registrarEmpleado()">Registrar Empleado</button>
                                <button type="button"  v-if="modificar==1"  class="btn btn-primary" @click="actualizarEmpleado()">Actualizar Empleado</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    <!-- Ver empleado -->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <p v-text="nombre"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Apellido</label>
                                <p v-text="apellido"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cuil</label>
                                    <p v-text="tipo_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Serie Comprobante</label>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número Comprobante</label>
                                   
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- fin ver empleado -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
           
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    import toastr from 'toastr'; 
   // import 'vue-select/dist/vue-select.css';
    //Vue.component("v-select", vSelect);
    Vue.component('v-select', VueSelect.VueSelect);
    export default {
        data (){
            return {
                empleado_id: 0,
                idincidencia:0,
                arrayCompetencias: [],
                competenciasId:[],
                cliente:'',
                nombre:'',
                apellido:'',
                cuil:'',
                fechaAlta:'',
                fechaBaja:'',
                curriculum:'',
                fechaNacimiento:'',
                direccion:'',
                arrayEmpleado: [],
                arrayIncidencia: [],
                arrayDetalle : [],
                listado:1,
                modificar: 0,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorEmpleado : 0,
                errorMostrarMsjEmpleado : [],
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
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
                
            }
        },
        components: {
            vSelect
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
            },
            calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad-this.arrayDetalle[i].descuento)
                }
                return resultado;
            }
        },
        methods : {
            listarEmpleado (page,buscar,criterio){
                let me=this;
                var url= '/empleado?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                     me.arrayEmpleado = respuesta.empleados.data;
                    //me.otroArray = respuesta.masinfo.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectIncidencia(){
                console.log("en select");
                let me=this;
                //loading(true)
                console.log("en select");
                var url= '/incidencia/selectIncidencia';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    //q: search
                    me.arrayIncidencia=respuesta.incidencias;
                    console.log(response.data.incidencias[0].nombre);
                    //loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCompetencia(){
                let me=this;
                //loading(true)
                var url= '/competencia/selectCompetencia';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    //q: search
                    me.arrayCompetencias=respuesta.competencias;
                    //loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            // listarIncidencia (search,loading){
            //     console.log("en select");
            //     let me=this;
            //     loading(true)
            //     var url= '/incidencia/selectIncidencia?filtro='+search;
            //     axios.get(url).then(function (response) {
            //         let respuesta = response.data;
            //         q: search
            //         me.arrayIncidencia=respuesta.incidencias;
            //         console.log(respuesta.incidencias);
            //         loading(false)
            //     })
            //     .catch(function (error) {
            //         console.log(error);
            //     });
            // },
            getDatosIncidencia(val1){
                let me = this;
                me.loading = true;
                me.idincidencia = val1.id;
            },
            buscarArticulo(){
                let me=this;
                var url= '/articulo/buscarArticuloVenta?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos;

                    if (me.arrayArticulo.length>0){
                        me.articulo=me.arrayArticulo[0]['nombre'];
                        me.idarticulo=me.arrayArticulo[0]['id'];
                        me.precio=me.arrayArticulo[0]['precio_venta'];
                        me.stock=me.arrayArticulo[0]['stock'];
                    }
                    else{
                        me.articulo='No existe artículo';
                        me.idarticulo=0;
                    }
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
                me.listarEmpleado(page,buscar,criterio);
            },
           
           
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idarticulo: data['id'],
                            articulo: data['nombre'],
                            cantidad: 1,
                            precio: data['precio_venta'],
                            descuento:0,
                            stock:data['stock']
                        }); 
                    }
            },
            listarArticulo (buscar,criterio){
                let me=this;
                var url= '/articulo/listarArticuloVenta?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarEmpleado(){
                let me = this;
                if (this.validarEmpleado()){
                    return;
                }
                if (me.esCUITValida()==false){

                     me.errorMostrarMsjEmpleado.push("El cuil ingresado no es válido");
                        me.errorEmpleado=1;
                    return;
                }
                axios.post('/empleado/registrar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'cuil': this.cuil,
                    'direccion': this.direccion,
                    'fechaNacimiento': this.fechaNacimiento,
                    'fechaAlta': this.fechaAlta,
                    'curriculum': this.curriculum,
                    //'empleado': this.empleado
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarEmpleado(1,'','nombre');
                    me.ocultarDetalle();
                    toastr.success('Se ha registrado el empleado', 'Registrado', {timeOut: 5000})
                }).catch(function (error) {
                    console.log(error);
                    toastr.error('Ha ocurrido un error', 'Error', {timeOut: 5000})
                });
            },
           actualizarEmpleado(){
               if (this.validarEmpleado()){
                    return;
                }
                
                let me = this;
                console.log(me.id);
                axios.put('/empleado/actualizar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'cuil': this.cuil,
                    'direccion': this.direccion,
                    'fechaNacimiento': this.fechaNacimiento,
                    'fechaAlta': this.fechaAlta,
                    'curriculum': this.curriculum,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarEmpleado(1,'','nombre');
                    me.ocultarDetalle();
                    toastr.success('Se ha actualizado el empleado', 'Actualizado', {timeOut: 5000})
                }).catch(function (error) {
                    console.log(error);
                    toastr.error('Ha ocurrido un error', 'Error', {timeOut: 5000})
                }); 
            },
            desactivarEmpleado(id){
               swal({
                title: 'Esta seguro de desactivar este empleado?',
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

                    axios.put('/empleado/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEmpleado(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
            activarEmpleado(id){
               swal({
                title: 'Esta seguro de activar este empleado?',
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

                    axios.put('/empleado/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEmpleado(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
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
            esCUITValida() {
                  console.log(this.cuil);
                    this.inputString = this.cuil.toString();
                    if (this.inputString.length == 11) {
 
                        var Caracters_1_2 = this.inputString.charAt(0) + this.inputString.charAt(1)
                        if (Caracters_1_2 == "20" || Caracters_1_2 == "23" || Caracters_1_2 == "24" || Caracters_1_2 == "27" || Caracters_1_2 == "30" || Caracters_1_2 == "33" || Caracters_1_2 == "34") {
                            var Count = this.inputString.charAt(0) * 5 + this.inputString.charAt(1) * 4 + this.inputString.charAt(2) * 3 + this.inputString.charAt(3) * 2 + this.inputString.charAt(4) * 7 + this.inputString.charAt(5) * 6 + this.inputString.charAt(6) * 5 + this.inputString.charAt(7) * 4 + this.inputString.charAt(8) * 3 + this.inputString.charAt(9) * 2 + this.inputString.charAt(10) * 1
                            var Division = Count / 11;
                            if (Division == Math.floor(Division)) {
                                return true
                            }
                        }
                    }
                    return false
            },
            valida(){
                const campoNumerico = document.getElementById('numero');

                campoNumerico.addEventListener('keydown', function(evento) {
                const teclaPresionada = evento.key;
                const teclaPresionadaEsUnNumero =
                    Number.isInteger(parseInt(teclaPresionada));

                const sePresionoUnaTeclaNoAdmitida = 
                    teclaPresionada != 'ArrowDown' &&
                    teclaPresionada != 'ArrowUp' &&
                    teclaPresionada != 'ArrowLeft' &&
                    teclaPresionada != 'ArrowRight' &&
                    teclaPresionada != 'Backspace' &&
                    teclaPresionada != 'Delete' &&
                    teclaPresionada != 'Enter' &&
                    !teclaPresionadaEsUnNumero;
                const comienzaPorCero = 
                    campoNumerico.value.length === 0 &&
                    teclaPresionada == 0;

                if (sePresionoUnaTeclaNoAdmitida || comienzaPorCero) {
                    evento.preventDefault(); 
                }

                });
            },
            validarEmpleado(){
                this.errorEmpleado=0;
                this.errorMostrarMsjEmpleado =[];

                if (!this.nombre) this.errorMostrarMsjEmpleado.push("El nombre del empleado no puede estar vacío.");
                if (!this.apellido) this.errorMostrarMsjEmpleado.push("El apellido del empleado no puede estar vacío.");
                if (!this.cuil) this.errorMostrarMsjEmpleado.push("El cuil del empleado no puede estar vacío.");
                if (!this.direccion) this.errorMostrarMsjEmpleado.push("La dirección del empleado no puede estar vacía.");
                if (!this.fechaAlta) this.errorMostrarMsjEmpleado.push("La fecha de ingreso del empleado no puede estar vacía.");
                if (!this.curriculum) this.errorMostrarMsjEmpleado.push("El curriculum del empleado no puede estar vacío.");
                if (this.errorMostrarMsjEmpleado.length) this.errorEmpleado = 1;

                return this.errorEmpleado;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.idproveedor=0;
                me.tipo_comprobante='BOLETA';
                me.serie_comprobante='';
                me.num_comprobante='';
                me.impuesto=0.18;
                me.total=0.0;
                me.idarticulo=0;
                me.articulo='';
                me.cantidad=0;
                me.precio=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
                this.modificar=0;
                this.nombre = '';
                this.apellido= '';
                this.cuil= '';
                this.direccion= '';
                this.fechaNacimiento= null;
                this.fechaAlta= null;
                this.curriculum= '';
                this.empleado_id = '';
            },
            verEmpleado(id){
                /*let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso
                var arrayEmpleadoT=[];
                var url= '/venta/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayEmpleadoT = respuesta.venta;
                    me.nombre = arrayEmpleadoT[0]['nombre'];
                    
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/venta/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });  */             
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            }, 
            modificarEmpleado(data = []){
                let me = this;
                me.listado=0;
                me.modificar=1;
                me.errorMostrarMsjEmpleado=[]; 
                me.id=data['id'];              
                me.nombre = data['nombre'];
                me.apellido=data['apellido'];
                me.cuil=data['cuil'];
                me.direccion=data['direccion'];
                me.fechaNacimiento=data['fechaNacimiento'];
                me.fechaAlta=data['fechaAlta'];
                me.fechaBaja=data['fechaBaja'];
                me.curriculum=data['curriculum'];
                
            },

        },
        mounted() {
            this.listarEmpleado(1,this.buscar,this.criterio);
            this.selectIncidencia();
            this.selectCompetencia();
        
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
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
