<template>
  <div class="container-fluid">
    <div :class="['row footer-container', footerClass]">
      <div class="col-6 col-md-4 col-lg-3 pe-0 d-flex pt-40 pb-20">
        <div class="ms-auto">
          <h4 :class="['titulo-footer', colorRosa]">CDMI</h4>
          <div class="container-color-blanco">
            <router-link to="/sobrenosotros"> Nosotros </router-link>
            <router-link :to="{ path: '/', hash: '#datosContacto' }">Ubicación</router-link>
            <router-link to="/contacto">Contacto</router-link>
            <router-link to="#">Preguntas Frecuentes</router-link>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center pt-40 pb-20">
        <div class="">
          <h4 :class="['titulo-footer', colorRosa]">SERVICIOS</h4>
          <div class="container-color-blanco">
            <router-link to="/pacientes" @click="changeLinkActive('pacientes')">Estudios Pacientes</router-link>
            <router-link to="/empresas" @click="changeLinkActive('empresas')">Estudios Empresas</router-link>
            <router-link to="/industrial" @click="changeLinkActive('industrial')">Estudios Industriales</router-link>
            <router-link to="/resultados">Resultados</router-link>
            <router-link to="/citas" @click="changeLinkActive('pacientes')">Agenda una Cita</router-link>
            <a href="atencionaclientes@cdmilab.com">Facturación</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-lg-3 pt-md-40 pb-20 d-flex flex-column">
        <div class="me-lg-auto">
          <h4 :class="['titulo-footer', 't-center', 'text-md-left', colorRosa]">LEGALES</h4>
          <div class="container-color-blanco t-center text-md-left">
            <router-link to="/avisoPrivacidad">Aviso de Privacidad</router-link>
            <router-link to="/terminosYCondiciones">Terminos y Condiciones</router-link>
            <router-link to="/politicaServicio">Política de Servicio</router-link>
          </div>
        </div>
        <!-- REDES INDUSTRIAL -->
        <div v-if="isEstudiosIndustrial" class="d-flex justify-content-center justify-content-md-end redes-container">
          <a href="https://mx.linkedin.com/" target="_blank" class="icon-footer-container me-2">
            <i class="fa-brands fa-linkedin-in"></i>
          </a>
          <a href="tel:+523315001469" class="icon-footer-container me-3">
            <i class="fa-brands fa-whatsapp"></i>
          </a>
        </div>
        <!-- REDES PACIENTE/EMPRESAS -->
        <div v-else class="d-flex mt-4 mt-md-auto justify-content-center justify-content-md-end redes-container">
          <a href="https://www.instagram.com/laboratorioscdmi/" target="_blank" class="icon-footer-container me-2">
            <i class="fa-brands fa-instagram"></i>
          </a>
          <a href="https://www.facebook.com/cdmilab?mibextid=LQQJ4d&rdid=Ow9KUL8SkYMUMtEo&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2FeGTGB4RwVMdMvcme%2F%3Fmibextid%3DLQQJ4d"
            target="_blank" class="icon-footer-container me-2">
            <i class="fa-brands fa-facebook-f"></i>
          </a>
          <a href="tel:+523315001469" class="icon-footer-container me-3">
            <i class="fa-brands fa-whatsapp"></i>
          </a>
        </div>
      </div>

      <!-- IMG ISO pt-40 pb-20 -->
      <div v-if="isEstudiosIndustrial" class="col-lg-3 py-3 py-md-5 fondo-blanco">
        <div class="row">
          <div class="col-sm-6 col-lg-12 px-5 px-lg-0 d-flex">
            <img class="img-fluid mx-auto" src="../../../assets/imagenes/licencia_iso.png" style="width: 250px;">
          </div>
          <div class="col-sm-6 col-lg-12 px-5 px-lg-0 d-flex">
            <img class="img-fluid mx-auto" src="../../../assets/imagenes/licencia_cofepris.png" style="width: 200px;">
          </div>
        </div>
      </div>

      <!-- IMG EMA -->
      <div v-else class="col-lg-3 container-color-blanco2 pt-40 pb-20">
        <div class="px-5 px-lg-0 mb-4 d-flex">
          <img class="img-fluid mx-auto" src="../../../assets/imagenes/logo_ema.jpg">
        </div>
        <p class="mb-0">Consulta nuestro alcance en</p>
        <div class="d-flex">
          <a class="mx-auto" href="https://www.ema.org.mx" target="_blank">www.ema.org.mx</a>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'Footer',
  computed: {
    ...mapGetters(['activeRouteFooter', 'getEstudiosSeleccionados', 'getEstudiosSelecEmpresas', 'getEstudiosSelecIndustrial']), //Para poder acceder a las funciones del store

    //Para mostrar una u otra parte del footer
    isEstudiosIndustrial() {
      return this.activeRouteFooter === 'industrial';
    },
    footerClass() {
      if (this.activeRouteFooter === 'industrial') {
        return 'footer-tinto';
      }
    },
    colorRosa() {
      if (this.activeRouteFooter === 'industrial') {
        return 'color-rosa';
      }
    },
  },
  methods: {
    changeLinkActive(ruta) {
      this.$store.commit('changeActiveRoute', ruta); //Actualizar variable general (para footer)
    },
  }
};
</script>

<style scoped>
.container-color-blanco a,
.container-color-blanco p {
  color: white;
  text-decoration: none;
  font-size: 14px;
  display: block;
  transition: all 0.3s ease;
}

.container-color-blanco2 {
  background: white;
}

.container-color-blanco2 img {
  width: 250px;
}

.container-color-blanco2 a {
  transition: all 0.3s ease;
}

.container-color-blanco a:hover,
.container-color-blanco2 a:hover {
  transform: scale(1.1);
}

.container-color-blanco2 a,
.container-color-blanco2 p {
  color: rgb(73, 73, 73);
  text-decoration: none;
  font-size: 14px;
  text-align: center;
}

.footer-container {
  background: #00a95e;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.footer-tinto {
  background: var(--color-tinto);
}

.titulo-footer {
  font-size: 22px;
  font-weight: 600;
  margin-bottom: 20px;
}

.icon-footer-container {
  color: white;
  font-size: 20px;
  border: 3px solid white;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
}

.icon-footer-container a {
  color: white;
}

.social-icons-container a {
  transition: all 0.2s ease;
}

.social-icons-container a:hover {
  transform: scale(1.15);
}

.redes-container a {
  transition: all 0.3s ease;
}

.redes-container a:hover {
  transform: scale(1.15);
}
</style>