<template>
  <div class="">
    <div class="banner-superior-container">
      <img :src="`./estudiosEmpresas/banner.png`" alt="Banner">
      <div class="btn-whats-container" @click="enviarMensaje">
        <div class="icon-whats-container">
          <i class="fa-brands fa-whatsapp"></i>
        </div>
        <p class="mb-0 ms-2 fw-500">más informes</p>
      </div>

    </div>
  </div>

  <div class="buscador-container">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 py-40 py-md-70 mx-auto">
          <div class="">
            <h2 class="text-center">Estudios Empresariales</h2>
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
        <h2 v-if="!inputBusqueda && !$route.query.search" class="text-center color-verde pt-4 pt-md-5 mb-md-5">Nuestros
          Paquetes Empresariales
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
                  <div class="btn-eye" data-bs-toggle="modal" data-bs-target="#detallesEstudiosEmpresas"
                    @click="seleccionandoEstudio(estudio)">
                    <i class="fa-regular fa-eye"></i>
                  </div>
                  <div :class="['btn-heart', isSelected(estudio) ? 'fondo-borde-verde' : '']"
                    @click="añadirEstudioEmpresas(estudio)">
                    <i :class="['fa-solid fa-cart-shopping', isSelected(estudio) ? 'color-blanco' : '']"></i>
                  </div>
                </div>
              </div>

              <div class="col-7 d-flex align-items-end pb-4">
                <div class="estudio-info-container">
                  <h5 class="color-verde">{{ estudio.nombre }}</h5>
                  <p v-if="estudio.precio !== '0.00'">Precio: <b>$ {{ formatearPrecio(estudio.precio) }} IVA
                      incluido</b></p>
                  <p class="mb-3">Código: <b>{{ estudio.codigo }}</b></p>
                  <button class="agendar-btn-container px-3 mt-3" @click="solicitarInformacion(estudio)">
                    Solicitar más Información
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
  <div class="modal fade" id="detallesEstudiosEmpresas" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                    @click="añadirEstudioEmpresas(estudioSeleccionado)">
                    <i class="fa-solid fa-cart-shopping"></i>
                  </div>
                </div>
              </div>
              <div class="col-9 ps-lg-5">
                <h5 class="color-verde">{{ estudioSeleccionado.nombre }}</h5>
                <div class="info-modal-container">
                  <p v-if="estudioSeleccionado.precio !== '0.00'">Precio: <b>$ {{
                    formatearPrecio(estudioSeleccionado.precio) }} IVA incluido</b></p>
                  <p>Código: <b>{{ estudioSeleccionado.codigo }}</b></p>
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
                  <button @click="solicitarInformacion(estudioSeleccionado)"
                    class="btn-container-modal mt-3 ms-auto text-center px-4" data-bs-dismiss="modal">
                    Solicitar más Información
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

export default {
  name: 'EstudiosEmpresas',
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
  async created() {
    await this.obtenerEstudios();
    await this.obtenerPaquetes();

    this.resultadosBusquedaNavBar(); //Para mostrar resultados por primera vez si se hace una busqueda desde el navbar
  },
  watch: {
    //Para observar cambios en el buscador del NavBar y mostrar resultados si se hace desde estudiosEmpresas.vue
    '$route.query.search': function () {
      this.resultadosBusquedaNavBar();
    },
  },
  computed: {
    ...mapGetters(['getEstudiosSelecEmpresas']),
    isSelected() {
      return estudio => this.getEstudiosSelecEmpresas.some(e => e.codigo === estudio.codigo);
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
  },
  methods: {
    enviarMensaje() {
      if (this.getEstudiosSelecEmpresas.length > 0) {
        const estudiosSeleccionados = this.getEstudiosSelecEmpresas;
        const listaEstudios = estudiosSeleccionados.map(e => `• ${e.nombre} (${e.codigo})`).join('\n');
        const numeroTelefono = 523315001469;
        const mensaje = `Hola me comunico desde el área Empresas de su sitio web, solicito información de los siguientes estudios por favor.\n ${listaEstudios}`;
        const urlWhatsapp = `https://wa.me/${numeroTelefono}?text=${encodeURIComponent(mensaje)}`;
        window.open(urlWhatsapp, '_blank')
      } else {
        window.open(`https://wa.me/523315001469?text=Hola me comunico desde el área Empresas de su sitio web, me gustaría mas información sobre sus servicios.`, '_blank')
      }
    },

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
        const response = await this.$axios.get('/obtenerEstudiosEmpresas');
        this.estudios = response.data;
        this.estudiosFiltrados = this.estudios;
        // console.log(this.estudios);
      } catch {
        console.error('Error obteniendo los estudios: ', error);
      }
    },
    async obtenerPaquetes() {
      try {
        const response = await this.$axios.get('/obtenerPaquetesPacientes');
        this.paquetes = response.data;
        this.paquetesFiltrados = this.paquetes;
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

    añadirEstudioEmpresas(estudio) {
      const estudioEncontrado = this.estudios.find(e => e.codigo === estudio.codigo); //Esta lina es necesaria, no quitarla.
      if (estudioEncontrado) {
        //Ejecutamos la funcion del estado globar de store.js
        this.$store.commit('añadirEstudioEmpresas', estudioEncontrado);
      } else {
        console.log('no se encontro el estudio')
      }
    },
    solicitarInformacion(estudio) {
      //Ejecutamos la funcion del estado global de store.js para agregar el estudio al mensaje
      this.$store.commit('añadirEstudioEmpresas2', estudio);
      //Se obtienen los estudios seleccionados desde el array global de store.js
      const estudiosSeleccionados = this.getEstudiosSelecEmpresas;
      const listaEstudios = estudiosSeleccionados.map(e => `• ${e.nombre} (${e.codigo})`).join('\n');
      const numeroTelefono = 523315001469;
      const mensaje = `Hola me comunico desde el área Empresas de su sitio web, solicito información de los siguientes estudios por favor:\n ${listaEstudios}`;
      const urlWhatsapp = `https://wa.me/${numeroTelefono}?text=${encodeURIComponent(mensaje)}`;
      window.open(urlWhatsapp, '_blank')
    },
    seleccionandoEstudio(estudio) {
      //busco el estudio o paquete seleccionado en el array estudio, esto lo hago por que la tabla paquetes no tiene todos los detalles como si lo tiene la tabla estudios
      const estudioFiltrado = this.estudios.find(e => e.codigo === estudio.codigo);
      this.estudioSeleccionado = estudioFiltrado;
    }
  },
};

</script>

<style scoped>
.btn-whats-container {
  background: #264415;
  display: inline-flex;
  align-items: center;
  color: white;
  border-radius: 20px;
  padding: 5px 15px;
  position: absolute;
  bottom: 0rem;
  right: 2rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

@media(min-width:768px) {
  .btn-whats-container {
    bottom: 1rem;
  }
}

@media(min-width:1024px) {
  .btn-whats-container {
    bottom: 3rem;
    right: 5rem;

  }
}

.btn-whats-container:hover {
  transform: scale(1.1);
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
}

.icon-whats-container {
  border: 2px solid white;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>