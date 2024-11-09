<template>
  <div class="conatiner-fluid">
    <div class="row banner-estudiosPacientes">
      <div class="col-6 d-flex pe-lg-5" style="height: 100%;">
        <img :src="`./estudiosPacientes/banner.png`" class="ms-auto mt-3" data-aos="fade-right">
      </div>
      <div class="col-6 ps-lg-5 d-flex align-items-center" >
        <h3 class="me-auto" data-aos="fade-left">Estudios Clínicos</h3>
      </div>

    </div>
  </div>

  <div class="buscador-container">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 py-40 py-md-70 mx-auto">
          <div class="">
            <h2 class="text-center">Estudios Individuales</h2>
            <div class="buscador-individual-container" id="resultados">
              <i class="fa-solid fa-magnifying-glass ps-4 pe-2"></i>
              <input v-model="inputBusqueda" @input="resultadosBusqueda" type="text">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container pb-5">
    <div class="row">
      <div class="col-lg-12">
        <h2 v-if="!inputBusqueda && !$route.query.search" class="text-center color-verde pt-4 pt-md-5 mb-md-5">
          Nuestros Paquetes
        </h2>
        <h2 v-else class="text-center color-verde pt-5 mb-md-5">Resultados</h2>
        <div class="row">
          <div v-if="this.estudiosFiltrados.length > 0" v-for="(estudio, index) in elementosPaginados" :key="index"
            class="col-md-6 col-lg-4 py-4 estudio-father-container">
            <div class="row">
              <div class="col-5">
                <div class="estudio-img-container">
                  <img :src="estudio.img ? `./iconos_estudios/${estudio.img}` : `./iconos_estudios/general.png`">
                </div>
                <div class="estudios-btns-container">
                  <!-- OJO -->
                  <div class="btn-eye" @click="seleccionandoEstudio(estudio)" data-bs-toggle="modal"
                    data-bs-target="#detallesEstudiosPacientes">
                    <i class="fa-regular fa-eye"></i>
                  </div>
                  <!-- CORAZON -->
                  <div :class="['btn-heart', isSelected(estudio) ? 'fondo-borde-verde' : '']"
                    @click="añadirEstudio(estudio)">
                    <i :class="['fa-solid fa-cart-shopping', isSelected(estudio) ? 'color-blanco' : '']"></i>
                  </div>
                </div>
              </div>

              <div class="col-7 d-flex align-items-end pb-4">
                <div class="estudio-info-container">
                  <h5 class="color-verde">{{ estudio.nombre }}</h5>
                  <p v-if="estudio.precio !== '0.00'">Precio: <b>$ {{ formatearPrecio(estudio.precio) }} IVA
                      incluido</b></p>
                  <p class="mb-4">Código: <b>{{ estudio.codigo }}</b></p>
                  <button class="agendar-btn-container" @click="agendarCita(estudio)">
                    Agendar cita
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p class="fw-bold fs-20 text-center color-gris font-italic">Sin coincidencias</p>
          </div>
          <div class="col-lg-12 mt-3">
            <Paginator :first="first" :rows="rows" :totalRecords="totalRecords" @page="onPageChange" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- START MODAL DETALLES ESTUDIO -->
  <div class="modal fade" id="detallesEstudiosPacientes" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-3">
                <div class="img-container-modal">
                  <img
                    :src="estudioSeleccionado.img ? `./iconos_estudios/${estudioSeleccionado.img}` : `./iconos_estudios/general.png`">
                </div>
                <div class="btns-container-modal">
                  <div
                    :class="['btn-heart-modal color-gris2', isSelected(estudioSeleccionado) ? 'fondo-borde-verde' : '']"
                    @click="añadirEstudio(estudioSeleccionado)">
                    <i class="fa-solid fa-cart-shopping"></i>
                  </div>
                </div>
              </div>
              <div class="col-9 ps-lg-5">
                <h5 class="color-verde">{{ this.estudioSeleccionado.nombre }}</h5>
                <div class="info-modal-container">
                  <p v-if="estudioSeleccionado.precio !== '0.00'">Precio: <b>$ {{
                    formatearPrecio(this.estudioSeleccionado.precio) }} IVA incluido</b></p>
                  <p>Código: <b>{{ this.estudioSeleccionado.codigo }}</b></p>
                  <p>Entrega de resultados: <b>{{ estudioSeleccionado.tiempo_entrega }}</b></p>
                  <p class="mb-4">Horario de toma de muestra: <b>{{ estudioSeleccionado.dias_proceso }}</b></p>
                  <p class="mb-4">Descripción: <b>{{ estudioSeleccionado.sinonimo }}</b></p>
                  <p class="mb-4">Tipo de muestra: <b>{{ estudioSeleccionado.tipo_muestra }}</b></p>
                  <div>
                    <p>Indicaciones al paciente:</p>
                    <ul class="mb-0"><b>• {{ estudioSeleccionado.indicaciones_paciente }}</b></ul>
                  </div>
                </div>
                <div class="d-flex">
                  <button @click="agendarCita(estudioSeleccionado)" class="btn-container-modal mt-3 ms-auto text-center"
                    data-bs-dismiss="modal">
                    Agendar cita
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- END MODAL DETALLES ESTUDIO -->
</template>

<script>
import { mapGetters } from 'vuex';
import { Modal } from 'bootstrap';

export default {
  name: 'EstudiosPacientes',
  data() {
    return {
      estudios: [],
      paquetes: [],
      estudiosFiltrados: [],
      paquetesFiltrados: [],
      inputBusqueda: '',
      estudioSeleccionado: {},
      precioTotal: null,

      //Para paginacion
      first: 0, //Indice del primer elemento
      rows: 6, //Numero de elementos por pagina
      totalRecords: 0 //Total de elementos en el array

    }
  },
  created() {
  },
  watch: {
    //Para observar cambios en el buscador del NavBar y mostrar resultados si se hace desde estudiosPacientes.vue
    '$route.query.search': function () {
      this.resultadosBusquedaNavBar();
    },
  },
  async mounted() {
    await this.obtenerEstudios();
    await this.obtenerPaquetes();
    //Para abrir modal de promocion
    this.checkAndOpenModal();
    this.resultadosBusquedaNavBar(); //Para mostrar resultados por primera vez si se hace una busqueda desde el navbar
  },

  computed: {
    //Para obtener estados globales para carrito(arrays globales)
    ...mapGetters(['getEstudiosSeleccionados']),
    isSelected() {
      return estudio => this.getEstudiosSeleccionados.some(e => e.codigo === estudio.codigo);
    },
    elementosPaginados() {
      let items = '';
      if (this.inputBusqueda || this.$route.query.search) {
        items = this.estudiosFiltrados;
      } else {
        items = this.paquetesFiltrados;
      }

      this.totalRecords = items.length;
      const start = this.first;
      const end = this.first + this.rows;
      return items.slice(start, end);
    },
    //Funcion para capturar el codigo que se envio desde pagina de inicio para mostrar el modal del estudio
    promocionEstudio() {
      const codigo = this.$route.query.codigo;
      if (codigo) {
        console.log(codigo);
        return this.estudios.find(e => e.codigo === codigo);
      }
      return null;
    }
  },
  methods: {
    //Funcion para buscador del Navbar
    resultadosBusquedaNavBar() {
      if (this.$route.query.search) { //Si hay un parametro de busqueda en la url se ejecuta el codigo
        const parametroBusqueda = this.$route.query.search ? this.$route.query.search.toLowerCase() : '';
        this.inputBusqueda = ''; //Limpio el input del buscador de la pagina

        this.estudiosFiltrados = this.estudios.filter(estudio =>
          estudio.codigo.toLowerCase().includes(parametroBusqueda) ||
          estudio.nombre.toLowerCase().includes(parametroBusqueda) ||
          estudio.sinonimo.toLowerCase().includes(parametroBusqueda)
        );
        //Esto es para que me lleve a la parte de los resultados, sobre todos sirve cuando hago una busqueda por primera vez
        // setTimeout(() => {
        //   const resultados = document.getElementById('resultados');
        //   if (resultados) {
        //     resultados.scrollIntoView({ behavior: 'smooth', block: 'start' });
        //   }
        // }, 100);
      }
    },
    //Funcion para el buscador del Componente
    resultadosBusqueda() {
      const parametroBusqueda = this.inputBusqueda.toLowerCase();

      this.estudiosFiltrados = this.estudios.filter(estudio =>
        estudio.codigo.toLowerCase().includes(parametroBusqueda) ||
        estudio.nombre.toLowerCase().includes(parametroBusqueda) ||
        estudio.sinonimo.toLowerCase().includes(parametroBusqueda)
      );
    },
    async obtenerEstudios() {
      try {
        const response = await this.$axios.get('/obtenerEstudiosPacientes');
        this.estudios = response.data;
        this.estudiosFiltrados = this.estudios;
        // console.log(this.estudios);
      } catch (error) {
        console.error('Error obteniendo los estudios:', error);
      }
    },
    async obtenerPaquetes() {
      try {
        const response = await this.$axios.get('/obtenerPaquetesPacientes');
        this.paquetes = response.data;
        this.paquetesFiltrados = this.paquetes;
        // console.log(this.paquetes);
      } catch (error) {
        console.error('Error obteniendo los paquetes: ', error);
      }
    },
    onPageChange(event) {
      this.first = event.first;
    },
    formatearPrecio(precio) {
      const numero = parseFloat(precio); //Se convierte el precio a decimal
      return numero.toLocaleString('es-MX', { //Se formatea a moneda mexicana
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },

    añadirEstudio(estudio) {
      //Se busca el paquete en el array estudios
      const estudioEncontrado = this.estudios.find(e => e.codigo === estudio.codigo); //Esta lina es necesaria, no quitarla.
      if (estudioEncontrado) {
        //Ejecutamos la funcion del estado globar de store.js
        this.$store.commit('añadirEstudio', estudioEncontrado);
      } else {
        console.log('no se encontro el estudio')
      }
    },
    agendarCita(estudio) {
      const estudioEncontrado = this.estudios.find(e => e.codigo === estudio.codigo); //Esta lina es necesaria, no quitarla.
      if (estudioEncontrado) {
        //Ejecutamos la funcion del estado globar de store.js
        this.$store.commit('añadirEstudio2', estudioEncontrado);
        this.$router.push('/citas');
      } else {
        console.log('no se encontro el estudio')
      }

    },
    seleccionandoEstudio(estudio) {
      //busco el estudio o paquete seleccionado en el array estudio, esto lo ago por que la tabla paquetes no tiene todos los detalles como si lo tiene la tabla estudios
      const estudioFiltrado = this.estudios.find(e => e.codigo === estudio.codigo);
      this.estudioSeleccionado = estudioFiltrado;
    },
    //Funcion para abrir modal de Promocion de Estudio
    checkAndOpenModal() {
      const codigo = this.$route.query.codigo;
      if (codigo) {
        const estudio = this.estudios.find(e => e.codigo === codigo)
        if (estudio) {
          this.seleccionandoEstudio(estudio);

          //Funcion para abrir modal del estudio si es que se recibio algun codigo desde la pagina Inicio
          this.$nextTick(() => {
            const modal = new Modal(document.getElementById('detallesEstudiosPacientes'));
            modal.show();
          });
        }
      }
    }
  },
};
</script>

<style scoped>

.banner-estudiosPacientes{
  background-image: url('../../../assets/imagenes/fondo_gris.png');
  background-size: cover;
  background-position: center;
  overflow: hidden;
  height: 250px;
  box-shadow: 0 0px 10px rgb(0, 0, 0, 0.3);
}
.banner-estudiosPacientes img {
  height: 100%;
  width: auto;
  object-fit: cover;
}

.banner-estudiosPacientes h3 {
  font-size: 1.5rem;
  text-align: center;
  color: var(--color-verde);
  font-weight: bold;
}

@media(min-width: 576px) and (max-width: 1024px) {
  .banner-estudiosPacientes {
    height: 400px;
  }

  .banner-estudiosPacientes h3 {
    font-size: 2rem;
  }
}

@media(min-width: 1025px) {
  .banner-estudiosPacientes {
    height: 550px;
  }


  .banner-estudiosPacientes h3 {
    font-size: 3rem;
  }
} </style>