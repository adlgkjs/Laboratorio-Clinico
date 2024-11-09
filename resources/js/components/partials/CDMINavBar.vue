<template>
  <!-- NAVBAR SUPERIOR -->
  <div class='fixed-top'>
    <nav :class="[navbarClass]">
      <div class="container-fluid d-flex px-0"> <!-- d-flex -->
        <router-link
          :class="['navbar-brand fs-20 px-4 py-2 link-hover ms-auto', isActive('pacientes') ? 'active-navSup' : '']"
          to="/pacientes" @click="changeLinkActive('pacientes')">Pacientes</router-link>
        <router-link :class="['navbar-brand fs-20 px-4 py-2 link-hover', isActive('empresas') ? 'active-navSup' : '']"
          to="/empresas" @click="changeLinkActive('empresas')">Empresas</router-link>
        <router-link :class="['navbar-brand fs-20 px-4 py-2 link-hover', isActive('industrial') ? 'active-navSup' : '']"
          to="/industrial" @click="changeLinkActive('industrial')">Industrial</router-link>
      </div>
    </nav>

    <nav :class="['navbar', 'navbar-expand-md', scrollClass]">
      <div class="container-fluid">
        <router-link class="navbar-brand ms-lg-5 py-0" to="/">
          <img :src="logoSrc" alt="Logo">
        </router-link>

        <div class="d-flex flex-column order-md-2">
          <div class="d-flex me-3">
            <div class="d-flex me-3">
              <!-- ICONO BUSCADOR -->
              <li class="nav-item buscador list-style-none d-flex" style="position: relative;" ref="buscadorNavBar">
                <a @click="toggleBuscador" exact-active-class="active-link"
                  class="fs-25 pe-3 my-auto mt-md-0 color-azul link-menu-principal">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </a>
                <div v-if="buscadorVisible" class="search-father-container">
                  <div class="search-individual-container">
                    <input v-model="inputBusqueda" @keydown.enter="buscarEstudios" ref="inputBuscador" type="text"
                      placeholder="Buscar">
                    <i @click="buscarEstudios" class="fa-solid fa-magnifying-glass"></i>
                  </div>
                </div>
              </li>
              <!-- ICONO CARRITO -->
              <li class="nav-item carrito list-style-none d-flex" style="position: relative;" ref="corazonIcon">
                <a @click="toggleCarrito" exact-active-class="active-link"
                  class="fs-30 fs-md-25 color-azul mt-md-0 link-menu-principal fw-bold">
                  <i class="fa-solid fa-cart-shopping"></i>
                  <div v-if="arrayEstudiosSelect.length > 0" :class="['contador-container', colorContadorCarrito]">
                    <p class="m-0 fs-12 text-center color-blanco">{{ arrayEstudiosSelect.length }}</p>
                  </div>
                </a>
                <!-- CARRITO DE COMPRAS -->
                <div v-if="carritoVisible" class="carrito-container">
                  <div v-if="arrayEstudiosSelect.length === 0">
                    <p class="text-center fw-bold fs-16">Añada algo al carrito</p>
                  </div>
                  <div v-for="(estudio, index) in arrayEstudiosSelect" :key="index" class="row p-2">
                    <div class="col-4 px-1">
                      <div class="estudio-img-container-carrito">
                        <img :src="estudio.img ? `./iconos_estudios/${estudio.img}` : `./iconos_estudios/general.png`">
                      </div>
                      <div class="estudios-btns-container">
                        <div :class="[isIndustrial ? 'btn-eye-tinto' : 'btn-eye']" data-bs-toggle="modal"
                          data-bs-target="#detallesEstudiosModal" @click="this.estudioSeleccionado = estudio">
                          <i class="fa-regular fa-eye"></i>
                        </div>
                        <div :class="getButtonClass(estudio)" @click="añadirEstudio(estudio, $event)">
                          <i class="fa-solid fa-cart-shopping color-blanco"></i>
                        </div>
                      </div>
                    </div>
                    <div class="col-8 px-1">
                      <div class="estudio-info-container">
                        <h5 :class="[isIndustrial ? 'color-tinto' : 'color-verde']">{{ estudio.nombre }}</h5>
                        <p>Precio: <b>$ {{ formatearPrecio(estudio.precio) }} IVA incluido</b></p>
                        <p>Código: <b>{{ estudio.codigo }}</b></p>
                        <p v-if="!isIndustrial" class="">Entrega de resultados: <b>{{ estudio.tiempo_entrega }}</b></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <hr>
                    <div class="d-flex">
                      <p class="col-6 fs-16">Total: <b>$ {{ formatearPrecio(sumaTotal) }}</b></p>
                      <p class="col-6 fs-16">No. Estudios: <b>{{ this.arrayEstudiosSelect.length }}</b></p>
                    </div>
                    <div class="d-flex">
                      <!-- Boton para Industrial -->
                      <button v-if="isIndustrial" class="agendar-btn-container-tinto" @click="solicitarInformacion()">
                        Solicitar más Información
                      </button>
                      <!-- Boton para Empresas -->
                      <button v-else-if="isEmpresas" class="agendar-btn-container px-4"
                        @click="solicitarInfoEmpresas()">
                        Solicitar más Información
                      </button>
                      <!-- Boton para Pacientes -->
                      <router-link v-else to="/citas" class="agendar-btn-container" @click="toggleCarrito">
                        Agendar cita
                      </router-link>
                    </div>
                  </div>
                </div>
                <!-- END CARRITO DE COMPRAS -->
              </li>
            </div>

            <!-- BOTON NAVBAR-->
            <button class="navbar-toggler" type="button" @click="toggleNavbar" @blur="ocultarNavbar">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
        </div>
        <!-- NAVBAR COLLAPSE -->
        <div :class="['collapse', 'navbar-collapse', 'order-md-1', 'mx-auto', { show: isNavbarOpen }]"
          id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0 align-items-center ms-auto">
            <li class="nav-item">
              <router-link exact-active-class="active-link" class="fs-5 px-3 px-lg-4 color-azul link-menu-principal"
                aria-current="page" to="/">Inicio</router-link>
            </li>
            <li class="nav-item">
              <a :class="['navbar-2', navbarClass2]" @click="rutaDinamica()"
                class="fs-5 px-3 px-lg-4 color-azul link-menu-principal">Estudios</a>
            </li>
            <li class="nav-item">
              <router-link exact-active-class="active-link" class="fs-5 px-3 px-lg-4 color-azul link-menu-principal"
                to="/resultados">Resultados</router-link>
            </li>
            <li class="nav-item">
              <router-link exact-active-class="active-link" class="fs-5 px-3 px-lg-4 color-azul link-menu-principal"
                to="/contacto">Contacto</router-link>
            </li>
          </ul>
        </div>
        <!-- END NAVBAR COLLAPSE -->
      </div>
    </nav>
  </div>

  <!-- START MODAL DETALLES ESTUDIO -->
  <div class="modal fade" id="detallesEstudiosModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-6 col-md-3 mx-auto mb-4">
                <div class="img-container-modal">
                  <img
                    :src="estudioSeleccionado.img ? `./iconos_estudios/${estudioSeleccionado.img}` : `./iconos_estudios/general.png`">
                </div>
                <!-- ICONO CORAZON -->
                <div class="btns-container-modal">
                  <div :class="getButtonClassModal(estudioSeleccionado)"
                    @click="añadirEstudio(estudioSeleccionado, $event)">
                    <i
                      :class="['fa-solid fa-cart-shopping', isSelected(estudioSeleccionado) ? 'color-blanco' : 'color-gris2']"></i>
                  </div>
                </div>
                <!-- END ICONO CARRITO -->
              </div>
              <div class="col-md-9 ps-lg-5">
                <h5 :class="[isIndustrial ? 'color-tinto' : 'color-verde']">{{ estudioSeleccionado.nombre }}</h5>
                <div class="info-modal-container">
                  <p>Precio: <b>$ {{ formatearPrecio(estudioSeleccionado.precio) }} IVA incluido</b></p>
                  <p>Código: <b>{{ estudioSeleccionado.codigo }}</b></p>
                  <div v-if="!isIndustrial">
                    <p>Entrega de resultados: <b>{{ estudioSeleccionado.tiempo_entrega }}</b></p>
                    <p class="mb-4">Horario de toma de muestra: <b>{{ estudioSeleccionado.dias_proceso }}</b></p>
                    <p class="mb-4">Descripción: <b>{{ estudioSeleccionado.sinonimo }}</b></p>
                    <p class="mb-4">Tipo de muestra: <b>{{ estudioSeleccionado.tipo_muestra }}</b></p>
                    <div>
                      <p>Indicaciones al paciente:</p>
                      <ul class="mb-0"><b>• {{ estudioSeleccionado.indicaciones_paciente }}</b></ul>
                    </div>
                  </div>
                </div>
                <div class="d-flex">
                  <!-- Boton para Industrial -->
                  <button v-if="isIndustrial" @click="solicitarInformacion()" class="btn-container-tinto-modal mt-3"
                    data-bs-dismiss="modal">
                    Solicitar más Información
                  </button>
                  <!-- Boton para Empresas -->
                  <button v-else-if="isEmpresas" @click="solicitarInfoEmpresas()" class="btn-container-modal mt-3"
                    data-bs-dismiss="modal">
                    Solicitar más Información
                  </button>
                  <!-- Boton para Pacientes -->
                  <button v-else @click="agendarCita(estudioSeleccionado)"
                    class="btn-container-modal mt-3 ms-auto text-center" data-bs-dismiss="modal">
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
// import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';

export default {

  name: 'MenuNavegacion',
  data() {
    return {
      isNavbarOpen: false,
      estudios: [],
      inputBusqueda: '',
      isScrolling: false,
      estudioSeleccionado: [],
      carritoVisible: false,
      buscadorVisible: false,
      arrayEstudiosSelect: [],
      activeRoute: 'pacientes',
    }
  },
  created() {
    this.obtenerEstudios();
    //Para scroll de NavBar
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeDestroy() {
    //Para scroll de NavBar
    window.removeEventListener('scroll', this.handleScroll);
  },
  mounted() {
    //Para ocultar o mostra el carrito de compras
    document.addEventListener('click', this.handleClickOutside);
    //Para ocultar o mostra el buscador del Navbar
    document.addEventListener('click', this.handleClickOutsideBuscador);

    if (this.$route.path === '/industrial') {
      this.changeLinkActive('industrial')
    } else if (this.$route.path === '/empresas') {
      this.changeLinkActive('empresas')
    }else if (this.$route.path === '/pacientes'){
      this.changeLinkActive('pacientes')
    }
  },
  beforeUnmount() {
    //Para ocultar o mostra el carrito de compras
    document.removeEventListener('click', this.handleClickOutside);
    //Para ocultar o mostra el buscador del Navbar
    document.removeEventListener('click', this.handleClickOutsideBuscador);
  },
  watch: {
    //Funcion para actualizar array que se itera en carrito de compras
    getEstudios() {
      switch (this.activeRouteFooter) {
        case 'pacientes':
          this.arrayEstudiosSelect = this.getEstudiosSeleccionados;
          break;
        case 'empresas':
          this.arrayEstudiosSelect = this.getEstudiosSelecEmpresas;
          break;
        case 'industrial':
          this.arrayEstudiosSelect = this.getEstudiosSelecIndustrial;
          break;
        // default:
        //   this.arrayEstudiosSelect = [];
      }
    },

    // '$route.path'(newPath) {
    //   if (newPath === '/industrial') {
    //     this.arrayEstudiosSelect = this.getEstudiosSelecIndustrial;
    //   } else {
    //     this.arrayEstudiosSelect = this.getEstudiosSeleccionados;
    //   }
    // }

  },
  computed: {
    //Obetenemos las variables globales del store.js
    ...mapGetters(['activeRouteFooter', 'getEstudiosSeleccionados', 'getEstudiosSelecEmpresas', 'getEstudiosSelecIndustrial']), //Para poder acceder a las funciones del store

    getEstudios() {
      switch (this.activeRouteFooter) {
        case 'pacientes':
          return this.arrayEstudiosSelect = this.getEstudiosSeleccionados;
        case 'empresas':
          return this.arrayEstudiosSelect = this.getEstudiosSelecEmpresas;
        case 'industrial':
          return this.arrayEstudiosSelect = this.getEstudiosSelecIndustrial;
      }
    },
    colorContadorCarrito() {
      if (this.isActive('pacientes')) {
        return 'fondo-verde';
      } else if (this.isActive('empresas')) {
        return 'fondo-verde-oscuro';
      } else if (this.isActive('industrial')) {
        return 'fondo-tinto';
      } else {
        return 'fondo-verde';
      }
    },

    sumaTotal() {
      return this.arrayEstudiosSelect.reduce((total, estudio) => {
        const precio = parseFloat(estudio.precio) || 0; //Convertir la cadena de texto a numero
        return total + precio;
      }, 0);
    },

    scrollClass() {
      return this.isScrolling ? 'navbar-scroll' : '';
    },
    navbarClass() {
      if (this.activeRouteFooter === 'pacientes') {
        return 'navbar-verde';
      } else if (this.activeRouteFooter === 'empresas') {
        return 'navbar-verde-oscuro';
      } else if (this.activeRouteFooter === 'industrial') {
        return 'navbar-tinto';
      }
      return 'navbar-verde';
    },
    navbarClass2() {
      const path = this.$route.path;
      if (path === '/pacientes') {
        return 'active-link';
      } else if (path === '/empresas') {
        return 'active-link';
      } else if (path == '/industrial') {
        return 'active-link';
      }
      return '';
    },
    logoSrc() {
      const path = this.$route.path;
      if (path === '/industrial') {
        return './logo_CAI.png'; //Esta ruta parte de public
      } else {
        return './logo_CDMI.png'; //Esta ruta parte de public
      }
    },
    isIndustrial() {
      return this.$route.path === '/industrial';
    },
    isEmpresas() {
      return this.$route.path === '/empresas';
    },
  },
  methods: {
    isActive(ruta) {
      return this.activeRouteFooter === ruta;
    },
    changeLinkActive(ruta) {
      this.activeRoute = ruta; //Actualizar variable local
      this.$store.commit('changeActiveRoute', ruta); //Actualizar variable general (para footer)
    },
    rutaDinamica() {
      if (this.isActive('pacientes')) {
        this.$router.push('/pacientes');
      } else if (this.isActive('empresas')) {
        this.$router.push('/empresas');
      } else if (this.isActive('industrial')) {
        this.$router.push('/industrial');
      }
    },
    isSelected(estudio) {
      return this.arrayEstudiosSelect.some(e => e.codigo === estudio.codigo)
    },
    getButtonClass(estudio) {
      const isSeleccionado = this.isSelected(estudio);
      const isIndustrial = this.isIndustrial;
      if (isSeleccionado && isIndustrial) {
        return 'btn-heart-tinto fondo-borde-tinto';
      } else if (isSeleccionado) {
        return 'btn-heart fondo-borde-verde';
      } else {
        return 'btn-heart;'
      }
    },
    getButtonClassModal(estudio) {
      const isSeleccionado = this.isSelected(estudio);
      const isIndustrial = this.isIndustrial;
      if (isSeleccionado && isIndustrial) {
        return 'btn-heart-tinto-modal fondo-borde-tinto';
      } else if (isSeleccionado && !isIndustrial) {
        return 'btn-heart-modal fondo-borde-verde';
      } else if (!isSeleccionado && isIndustrial) {
        return 'btn-heart-tinto-modal';
      } else if (!isSeleccionado && !isIndustrial) {
        return 'btn-heart-modal';
      }
    },
    toggleNavbar() {
      this.isNavbarOpen = !this.isNavbarOpen;
    },
    ocultarNavbar() {
      setTimeout(() => {
        this.isNavbarOpen = false;
      }, 100)
    },
    async obtenerEstudios() {
      try {
        const response = await this.$axios.get('/obtenerEstudiosTodos');
        this.estudios = response.data;
      } catch {
        console.error('Error obteniendo los estudios para el NavBar: ', error);
      }
    },
    handleScroll() {
      this.isScrolling = window.scrollY > 300;
    },
    añadirEstudio(estudio, $event) {
      if (this.activeRoute === 'pacientes') {
        this.$store.commit('añadirEstudio', estudio);
      } else if (this.activeRoute === 'empresas') {
        this.$store.commit('añadirEstudioEmpresas', estudio);
      } else if (this.activeRoute === 'industrial') {
        this.$store.commit('añadirEstudioIndustrial', estudio);
      }
      $event.stopPropagation();
    },
    agendarCita() {
      //Ejecutamos la funcion del estado globar de store.js
      this.$router.push('/citas'); //Esto es para que el carrito no se cierre al deseleccionar algun estudio
    },
    solicitarInformacion() {
      //Se obtienen los estudios seleccionados desde el array global de store.js
      if (this.getEstudiosSelecIndustrial.length > 0) {
        const estudiosSeleccionados = this.getEstudiosSelecIndustrial;
        const listaEstudios = estudiosSeleccionados.map(e => `• ${e.nombre} (${e.codigo})`).join('\n');
        const numeroTelefono = 523315001469;
        const mensaje = `Hola me comunico desde el área Industrial de su página web, solicito información de los siguientes estudios, por favor.\n ${listaEstudios}`;
        const urlWhatsapp = `https://wa.me/${numeroTelefono}?text=${encodeURIComponent(mensaje)}`;
        window.open(urlWhatsapp, '_blank')
        this.toggleCarrito(); //Para ocultar el carrito
      } else {
        window.open(`https://wa.me/523315001469?text=Hola me comunico desde el área Industrial de su sitio web, me gustaría mas información sobre sus servicios.`, '_blank')

      }
    },
    solicitarInfoEmpresas() {
      //Se obtienen los estudios seleccionados desde el array global de store.js
      if (this.getEstudiosSelecEmpresas.length > 0) {
        const estudiosSeleccionados = this.getEstudiosSelecEmpresas;
        const listaEstudios = estudiosSeleccionados.map(e => `• ${e.nombre} (${e.codigo})`).join('\n');
        const numeroTelefono = 523315001469;
        const mensaje = `Hola me comunico desde el área Empresas de su sitio web, solicito información de los siguientes estudios por favor:\n ${listaEstudios}`;
        const urlWhatsapp = `https://wa.me/${numeroTelefono}?text=${encodeURIComponent(mensaje)}`;
        window.open(urlWhatsapp, '_blank')
        this.toggleCarrito(); //Para ocultar el carrito
      } else {
        window.open(`https://wa.me/523315001469?text=Hola me comunico desde el área Empresas de su sitio web, me gustaría mas información sobre sus servicios.`, '_blank')
      }
    },
    formatearPrecio(precio) {
      const numero = parseFloat(precio); //Se convierte el precio a decimal
      return numero.toLocaleString('es-MX', { //Se formatea a moneda mexicana
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },
    toggleCarrito() {
      setTimeout(() => {
        this.carritoVisible = !this.carritoVisible;
      }, 100)
    },
    toggleBuscador() {
      this.buscadorVisible = !this.buscadorVisible;

      //Para enfocar el input del buscador automaticamente
      if (this.buscadorVisible) {
        this.$nextTick(() => { //nestTick() es una funcion que asegura que una accion se ejecute despues de que el DOM se haya actaulizado.
          this.$refs.inputBuscador.focus();
        })
      }
    },
    //Esta funcion maneja los clicks fuera del carrito de compras
    handleClickOutside(event) { //event es el objeto de evento click
      const carritoContainer = this.$refs.corazonIcon; //this.$refs accede a elementos del DOM que tienen una referencia "ref"
      if (carritoContainer && !carritoContainer.contains(event.target)) {
        this.carritoVisible = false;
      }
    },
    //Esta funcion maneja los clicks fuera del buscador del NavBar
    handleClickOutsideBuscador(event) { //event es el objeto de evento clic
      const buscador = this.$refs.buscadorNavBar; //this.$refs accede a elementos del DOM que tienen una referencia "ref"
      if (buscador && !buscador.contains(event.target)) {
        this.buscadorVisible = false;
      }
    },
    async buscarEstudios() {
      //La funcion "resultadosBusquedaNavBar" en estudiosPacientes.vue es la que cacha esta informacion
      if (this.activeRoute === 'pacientes') {
        this.$router.push({ path: '/pacientes', hash: '#resultados', query: { search: this.inputBusqueda } });
      } else if (this.activeRoute === 'empresas') {
        this.$router.push({ path: '/empresas', hash: '#resultados', query: { search: this.inputBusqueda } });
      } else if (this.activeRoute === 'industrial') {
        this.$router.push({ path: '/industrial', hash: '#resultados', query: { search: this.inputBusqueda } });
      }
      this.inputBusqueda = ''; //Se limpia el buscador      
    },
  },
};
</script>

<style scoped>
.link-hover {
  transition: all 0.3s ease;
  /* line-height: 3; */
}

.link-hover:hover {
  background-color: white;
  color: #2656cc;
  font-weight: 600;
}

.navbar-brand img {
  height: 90px;
  transition: all 0.3s ease;
}

.navbar-scroll {
  background: rgba(255, 255, 255, 0.9);
  transition: all 0.5s ease;
}

.navbar-scroll .navbar-brand img {
  height: 70px;
  transition: all 0.3s ease;

}

.active-navSup {
  background: white;
  color: #2656cc !important;
  font-weight: 600;
  transition: all 0.3s ease;

}

.navbar-verde {
  position: relative;
  background: #00a95e;
  color: white;
  z-index: 100;
  transition: all 0.2s ease;
}

.navbar-verde-oscuro {
  position: relative;
  background: #004207;
  color: white;
  z-index: 100;
  transition: all 0.2s ease;
}

.navbar-tinto {
  position: relative;
  background: var(--color-tinto);
  color: white;
  z-index: 100;
  transition: all 0.2s ease;
}

.active-link {
  color: #00a95e;
  transition: all 0.3s ease;
}

.link-menu-principal {
  font-weight: bold;
  text-decoration: none;
  transition: all 0.3s ease;
  cursor: pointer;
}

.link-menu-principal:hover {
  color: #00a95e;
}

.contador-container {
  position: absolute;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  bottom: 0;
  right: -8px;

}

.carrito-container {
  position: absolute;
  top: 100%;
  right: 100%;
  background: white;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  width: 400px;
  padding: 15px;
  max-height: 70vh;
  overflow: auto;
}

.carrito-container .row:hover {
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
  border-radius: 5px;
}

.search-father-container {
  position: absolute;
  top: 100%;
  right: 30px;
  padding: 12px 15px;
  background: white;
  border-radius: 30px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

@media(max-width: 516px) {
  .search-father-container {
    right: 0px;
  }

  .carrito-container {
    right: -80px;
  }
}

.search-individual-container {
  border: 2px solid #2656cc;
  border-radius: 15px;
  padding: 0px 10px;
  font-size: 16px;
  display: flex;
}

.search-individual-container i {
  margin: auto;
  color: #0054cc;
  cursor: pointer;
}

.search-individual-container input {
  border: none;
  padding: 3px 0px;
  border-radius: 5px;
}

.search-individual-container input:focus {
  outline: none;
}
</style>