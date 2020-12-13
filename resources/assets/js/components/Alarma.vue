<template>
  <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">Alarmas</div>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-header">Eventos Proximos</div>
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-md-6">
                      <div class="input-group">
                        <select
                          class="form-control col-md-3"
                          v-model="criEvento"
                        >
                          <option value="titulo">Título</option>
                        </select>
                        <input
                          type="text"
                          v-model="buEvento"
                          @keyup.enter="listarEvento(1, buEvento, criEvento)"
                          class="form-control"
                          placeholder="Texto a buEvento"
                        />
                        <button
                          type="submit"
                          @click="listarEvento(1, buEvento, criEvento)"
                          class="btn btn-primary"
                        >
                          <i class="fa fa-search"></i> BuEvento
                        </button>
                      </div>
                    </div>
                  </div>
                  <table class="table table-bordered table-striped table-sm">
                    <thead>
                      <tr>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Departamento(id)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="evento in arrayEvento" :key="evento.id">
                        <td v-text="evento.titulo"></td>
                        <td v-text="evento.fecha"></td>
                        <td v-text="evento.fecha"></td>
                      </tr>
                    </tbody>
                  </table>
                  <nav>
                    <ul class="pagEvento">
                      <li class="page-item" v-if="pagEvento.current_page > 1">
                        <a
                          class="page-link"
                          href="#"
                          @click.prevent="
                            cambiarPaginaEvento(
                              pagEvento.current_page - 1,
                              buEvento,
                              criEvento
                            )
                          "
                          >Ant</a
                        >
                      </li>
                      <li
                        class="page-item"
                        v-for="page in pagesNumberEvento"
                        :key="page"
                        :class="[page == isActivedEvento ? 'active' : '']"
                      >
                        <a
                          class="page-link"
                          href="#"
                          @click.prevent="cambiarPaginaEvento(page, buEvento, criEvento)"
                          v-text="page"
                        ></a>
                      </li>
                      <li
                        class="page-item"
                        v-if="pagEvento.current_page < pagEvento.last_page"
                      >
                        <a
                          class="page-link"
                          href="#"
                          @click.prevent="
                            cambiarPaginaEvento(
                              pagEvento.current_page + 1,
                              buEvento,
                              criEvento
                            )
                          "
                          >Sig</a
                        >
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <div class="card-header">Solicitudes de Inasistencias</div>
                <div class="card-body"></div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <div class="card-header">Dias No Laborales</div>
                <div class="card-body"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Ejemplo de tabla Listado -->
    
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <!--Fin del modal-->
  </main>
</template>

<script>
import toastr from "toastr";
export default {
  data() {
    return {
      arrayEmpresas: [],
      arrayareas: [],
      arrayEvento: [],

      id: 0,
      nombre: "",
      descripcion: "",
      empresa_id: 0,
    
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorComponente: 0,
      errorMostrarMsjForm: [],
      
      pagEvento: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
      offset: 3,
      criEvento: "nombre",
      buEvento: "",
    };
  },
  computed: {
    isActivedEvento: function () {
      return this.pagEvento.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumberEvento: function () {
      if (!this.pagEvento.to) {
        return [];
      }

      var from = this.pagEvento.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;
      if (to >= this.pagEvento.last_page) {
        to = this.pagEvento.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
  },
  methods: {
    listarEvento(page, buEvento, criEvento) {
      let me = this;
      var url =
        "/evento?page=" + page + "&buscar=" + buEvento + "&criterio=" + criEvento;
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.arrayEvento = respuesta.eventos.data;
          me.pagEvento = respuesta.pagEvento;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    cambiarPaginaEvento(page, buEvento, criEvento) {
      let me = this;
      //Actualiza la página actual
      me.pagEvento.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarEvento(page, buEvento, criEvento);
    },

    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";

      this.nombre = "";
      this.descripcion = "";
      this.empresa_id = 0;
    },


    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "area": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar area";

              this.id = 0;
              this.nombre = "";
              this.descripcion = "";
              this.empresa_id = 0;

              this.tipoAccion = 1;
              break;
            }
            case "actualizar": {
              this.modal = 1;
              this.tituloModal = "Actualizar area";
              this.tipoAccion = 2;

              this.id = data["id"];
              this.nombre = data["nombre"];
              this.descripcion = data["descripcion"];
              this.empresa_id = data["empresa_id"];

              break;
            }
          }
        }
      }
    },
  },
  mounted() {
    this.listarEvento(1, this.buEvento, this.criEvento);
  },
};
</script>
<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>
