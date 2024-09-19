<template>
  <div class="">
    <div class="banner-superior-container position-relative">
      <img :src="`./estudiosIndustrial/banner.png`">
      <div class="btn-whats-container" @click="enviarMensaje">
        <div class="icon-whats-container">
          <i class="fa-brands fa-whatsapp"></i>
        </div>
        <p class="mb-0 ms-2 fw-500">más informes</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row justify-content-center padding-top-4 py-md-5">
      <div class="col-lg-11">
        <div class="">
          <h2 class="text-center color-tinto mb-4">Centro de Análisis Industriales</h2>
          <p class="text-justify color-gris">En Centro de Análisis Industrial (CAI) de ensayos Microbiológicos y
            Fisicoquímicos, estamos comprometidos en brindar
            servicios con la más alta calidad, a través de las buenas prácticas profesionales; cumpliendo con los
            objetivos de calidad
            aplicables, el apego estricto de la ISO/IEC 17025:2017 “Requisitos generales para la competencia de los
            laboratorios de
            ensayo y calibración” y las expectativas de los clientes; lo anterior, con el propósito de mantener nuestro
            Sistema Integral
            de Gestión de la Calidad a través de resultados confiables y oportunos.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="buscador-container">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 py-40 py-md-70 mx-auto">
          <div class="">
            <h2 class="text-center ">Estudios Industriales</h2>
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
        <h2 v-if="inputBusqueda || $route.query.search" class="text-center color-tinto pt-5 ">Resultados</h2>
        <div class="row">
          <div v-if="this.estudiosFiltrados.length > 0" v-for="(estudio, index) in elementosPaginados" :key="index"
            class="col-md-6 col-lg-4 py-4 estudio-father-container">
            <div class="row">
              <div class="col-5">
                <div class="estudio-img-container">
                  <img :src="estudio.img ? `./iconos_estudios/${estudio.img}` : `./iconos_estudios/general.png`">
                </div>
                <div class="estudios-btns-container">
                  <div class="btn-eye" @click="seleccionandoEstudio(estudio)" data-bs-toggle="modal"
                    data-bs-target="#detallesEstudiosIndustrial">
                    <i class="fa-regular fa-eye"></i>
                  </div>
                  <div :class="['btn-heart', isSelected(estudio) ? 'fondo-borde-tinto' : '']"
                    @click="añadirEstudioIndustrial(estudio)">
                    <i :class="['fa-solid fa-cart-shopping', isSelected(estudio) ? 'color-blanco' : '']"></i>
                  </div>
                </div>
              </div>

              <div class="col-7 d-flex align-items-end pb-4">
                <div class="estudio-info-container">
                  <h5 class="color-tinto">{{ estudio.nombre }}</h5>
                  <p v-if="estudio.precio !== '0.00'">Precio: <b>$ {{ formatearPrecio(estudio.precio) }} IVA
                      incluido</b></p>
                  <p>Código: <b>{{ estudio.codigo }}</b></p>
                  <button class="agendar-btn-container-tinto mt-3" @click="solicitarInformacion(estudio)">
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

  <div class="">
    <div class="banner-footer-container">
      <img class="banner-footer" :src="`./estudiosIndustrial/banner_footer.png`">
      <img class="logo-banner-footer" :src="`./logo_CAI.png`" data-aos="fade-right">
    </div>
  </div>

  <!-- START MODAL DETALLES ESTUDIO -->
  <div class="modal fade" id="detallesEstudiosIndustrial" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                    :class="['btn-heart-modal color-gris2', isSelected(estudioSeleccionado) ? 'fondo-borde-tinto' : '']"
                    @click="añadirEstudioIndustrial(estudioSeleccionado)">
                    <i class="fa-solid fa-cart-shopping"></i>
                  </div>
                </div>
              </div>
              <div class="col-9 ps-lg-5">
                <h5 class="color-tinto">{{ this.estudioSeleccionado.nombre }}</h5>
                <div class="info-modal-container">
                  <p v-if="estudioSeleccionado.precio !== '0.00'">Precio: <b>$ {{
                    formatearPrecio(this.estudioSeleccionado.precio) }} IVA incluido</b></p>
                  <p>Código: <b>{{ this.estudioSeleccionado.codigo }}</b></p>
                </div>
                <div class="d-flex">
                  <button @click="solicitarInformacion(estudioSeleccionado)"
                    class="btn-container-tinto-modal mt-3 ms-auto text-center" data-bs-dismiss="modal">
                    Solicitar más Informacíon
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
  name: 'EstudiosIndustrial',
  data() {
    return {
      estudios: [],
      estudiosFiltrados: [],
      inputBusqueda: '',
      estudioSeleccionado: {},
      precioTotal: null,

      //Para paginacion
      first: 0, //Indice del primer elemento
      rows: 9, //Numero de elementos por pagina
      totalRecords: 0 //Total de elementos en el array
    }
  },
  async created() {
    await this.obtenerEstudios();

    this.resultadosBusquedaNavBar(); //Para mostrar resultados por primera vez si se hace una busqueda desde el navbar
  },
  watch: {
    //Para observar cambios en el buscador del NavBar y mostrar resultados si se hace desde estudiosIndustrial.vue
    '$route.query.search': function () {
      this.resultadosBusquedaNavBar();
    },
  },
  computed: {
    //Para obtener estados globales para carrito(arrays globales)
    ...mapGetters(['getEstudiosSelecIndustrial']),
    isSelected() {
      return estudio => this.getEstudiosSelecIndustrial.some(e => e.codigo === estudio.codigo);
    },
    elementosPaginados() {
      let items = this.estudiosFiltrados;

      this.totalRecords = items.length;
      const start = this.first;
      const end = this.first + this.rows;
      return items.slice(start, end);
    },
  },
  methods: {
    enviarMensaje() {
      if (this.getEstudiosSelecIndustrial.length > 0) {
        const estudiosSeleccionados = this.getEstudiosSelecIndustrial;
        const listaEstudios = estudiosSeleccionados.map(e => `• ${e.nombre} (${e.codigo})`).join('\n');
        const numeroTelefono = 523315001469;
        const mensaje = `Hola me comunico desde el área Industrial de su página web, solicito información de los siguientes estudios, por favor.\n ${listaEstudios}`;
        const urlWhatsapp = `https://wa.me/${numeroTelefono}?text=${encodeURIComponent(mensaje)}`;
        window.open(urlWhatsapp, '_blank')
      } else {
        window.open(`https://wa.me/523315001469?text=Hola me comunico desde el área Industrial de su sitio web, me gustaría mas información sobre sus servicios.`, '_blank')
      }
    },
    //Funcion para buscador del Navbar
    resultadosBusquedaNavBar() {
      if (this.$route.query.search) { //Si hay un parametro de busqueda en la url se ejecuta el codigo
        const parametroBusqueda = this.$route.query.search ? this.$route.query.search.toLowerCase() : '';
        this.inputBusqueda = ''; //Limpio el input del buscador de la pagina

        this.estudiosFiltrados = this.estudios.filter(estudio =>
          estudio.codigo.toLowerCase().includes(parametroBusqueda) ||
          estudio.nombre.toLowerCase().includes(parametroBusqueda) 
        );
        //Esto es para que me lleve a la parte de los resultados, sobre todos sirve cuando hago una busqueda por primera vez
        // setTimeout(() => {
        //   const resultados = document.getElementById('resultados');
        //   if (resultados) {
        //     resultados.scrollIntoView({ behavior: 'smooth', block: 'start' });
        //   }
        // }, 50);
      }
    },
    //Funcion para buscador del componente
    resultadosBusqueda() {
      const parametroBusqueda = this.inputBusqueda.toLowerCase();

      this.estudiosFiltrados = this.estudios.filter(estudio =>
        estudio.codigo.toLowerCase().includes(parametroBusqueda) ||
        estudio.nombre.toLowerCase().includes(parametroBusqueda)
      );
    },
    async obtenerEstudios() { //Consulta a tabla "paquetes"
      try {
        const response = await this.$axios.get('/obtenerEstudiosIndustrial');
        this.estudios = response.data;
        this.estudiosFiltrados = this.estudios;
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
    añadirEstudioIndustrial(estudio) {
      //Ejecutamos la funcion "añadirEstudioIndustrial" del estado global de store.js
      this.$store.commit('añadirEstudioIndustrial', estudio);
    },
    solicitarInformacion(estudio) {
      //Ejecutamos la funcion del estado global de store.js para agregar el estudio al mensaje
      this.$store.commit('añadirEstudioIndustrial2', estudio);
      //Se obtienen los estudios seleccionados desde el array global de store.js
      const estudiosSeleccionados = this.getEstudiosSelecIndustrial;
      const listaEstudios = estudiosSeleccionados.map(e => `• ${e.nombre} (${e.codigo})`).join('\n');
      const numeroTelefono = 523315001469;
      const mensaje = `Hola me comunico desde el área Industrial de su página web, solicito información de los siguientes estudios, por favor. \n ${listaEstudios}`;
      const urlWhatsapp = `https://wa.me/${numeroTelefono}?text=${encodeURIComponent(mensaje)}`;
      window.open(urlWhatsapp, '_blank')
    },
    seleccionandoEstudio(estudio) {
      //busco el estudio o paquete seleccionado en el array estudio, esto lo ago por que la tabla paquetes no tiene todos los detalles como si lo tiene la tabla estudios
      this.estudioSeleccionado = estudio;
    },
  },
};
</script>

<style scoped>
.banner-footer-container {
  overflow: hidden;
  position: relative;
  height: 200px;
}

.banner-footer-container .banner-footer {
  object-fit: cover;
  width: 100%;
  height: 100%;
}

.logo-banner-footer {
  position: absolute;
  width: 150px;
  top: 10%;
  left: 15%;
}

.buscador-container h2 {
  color: var(--color-tinto);
}

.buscador-individual-container {
  border: 3px solid var(--color-tinto);
}

.buscador-individual-container i {
  color: var(--color-tinto);
}

.agendar-btn-container,
.btn-container-modal {
  border: 2px solid var(--color-tinto);
  color: var(--color-tinto);

}

.agendar-btn-container:hover,
.btn-container-modal:hover {
  background: var(--color-tinto);
  color: white;
}

.btn-eye:hover,
.btn-heart:hover,
.btn-heart-modal:hover {
  background: var(--color-tinto);
  border: 1px solid var(--color-tinto);
}


.p-paginator-page.p-highlight {
  background: var(--color-tinto);
}

.btn-whats-container {
  background: var(--color-tinto);
  display: inline-flex;
  align-items: center;
  color: white;
  border-radius: 20px;
  padding: 5px 15px;
  position: absolute;
  bottom: 0rem;
  right: 5rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

@media(min-width:768px) {
  .btn-whats-container {
    bottom: 2rem;
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