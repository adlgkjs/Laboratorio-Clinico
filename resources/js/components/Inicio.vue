<template>
  <div class="container-fluid">
    <div class="row">
      <router-link to="/pacientes" @click="changeLinkActive('pacientes')" class="col-md-6 col-lg-4 analisis-fhater-container p-3 p-md-0">
        <div class="img-container-analisis">
          <img class="" src="../../assets/imagenes/inicio/analisis_pacientes.png">
        </div>
        <div class="analisis-container-1">
          <p class="color-white">Análisis Clínicos Pacientes</p>
        </div>
      </router-link>
      <router-link to="/empresas" @click="changeLinkActive('empresas')" class="col-md-6 col-lg-4 analisis-fhater-container p-3 p-md-0">
        <div class="img-container-analisis">
          <img class="" src="../../assets/imagenes/inicio/analisis_empresariales.png">
        </div>
        <div class="analisis-container-2">
          <p>Análisis Clínicos Empresariales</p>
        </div>
      </router-link>
      <router-link to="/industrial" @click="changeLinkActive('industrial')" class="col-lg-4 analisis-fhater-container p-3 p-lg-0">
        <div class="img-container-analisis ">
          <img class="" src="../../assets/imagenes/inicio/analisis_industriales.png">
        </div>
        <div class="analisis-container-3">
          <p>Análisis Industriales</p>
        </div>
      </router-link>
    </div>
  </div>

  <!-- MAIN -->
  <div class="conteiner">
    <div class="d-flex my-60">
      <div class="col-lg-8 mx-auto px-3">
        <h2 class="text-center mb-4 color-verde">Análisis Clínicos de Alta Especialidad</h2>
        <p class="text-justify color-gris">Somos un laboratorio mexicano dedicado al diagnóstico de análisis clínicos de
          alta
          especialidad, con más de 8 años brindando un excelente servicio, utilizando la más avanzada tecnología y un
          equipo altamente calificado para garantizar exactitud, precisión y la confiabilidad de los resultados para los
          pacientes, médicos y clientes del sector público y privado.</p>
      </div>
    </div>
  </div>

  <!-- PROMOCIONES -->
  <div class="py-6" style="background: #f4f6f9;">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-4">
          <!-- Lind Prenatal II, estos eran divs -->
          <div class="img-promocion-container">
            <router-link @click="changeLinkActive('pacientes')" :to="{ path: '/pacientes', query: { codigo: 'QC056' } }">
              <img :src="`./inicio/prenatal_II.png`">
            </router-link>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <!-- Link General -->
          <div class="img-promocion-container">
            <router-link @click="changeLinkActive('pacientes')" :to="{ path: '/pacientes', query: { codigo: 'PQ004' } }">
              <img :src="`./inicio/general.png`">
            </router-link>
          </div>
        </div>
        <div class="col-md-8 col-lg-4 mx-auto">
          <!-- Link Diabetes I -->
          <div class="img-promocion-container">
            <router-link @click="changeLinkActive('pacientes')" :to="{ path: '/pacientes', query: { codigo: 'PQ071' } }">
              <img :src="`./inicio/diabetes_I.png`">
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END PROMOCIONES -->

  <div class="">
    <div class="img-fondo-gris ">
      <div class="img-resultados-container">
        <img class="me-md-4 me-lg-5" src="../../assets/imagenes/inicio/descargar_resultados.png" data-aos="fade-right">
        <div class="ms-md-4 ms-lg-5 d-flex flex-column justify-content-center ms-lg-3">
          <h3 class="color-azul fw-bold" data-aos="fade-left">Descarga <br> tus Resultados</h3>
          <router-link to="/resultados" class="link-resultados-container" id="datosContacto" data-aos="fade-left">
            Haz clic aqui
          </router-link>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-4 pt-6 pb-md-6">
        <div class="datos-contacto-container" data-aos="fade-right">
          <h3 class="color-azul fw-bold">Visítanos</h3>
          <a href="https://maps.app.goo.gl/xQo2dqs8VdaCV5gg7" target="_blank" class="mt-4 d-block mb-3"><b>Dirección:
            </b>Calle Volcán Vesubio 6271, Col. El Colli Urbano, CP. 45070, Zapopan, Jal.
          </a>
          <p><b>Horario de Atención:</b> Luneas a Viernes de 07:00 a 18:00 hrs. Sábado de 07:00 a 14:00 hrs.</p>
          <a href="tel:+523344453900" target="_blank" class="d-block"><b>Tel: </b>+52 (33) 4445 3900</a>
          <a href="https://wa.me/523315001469?text= Hola me comunico desde su sitio web," target="_blank"><b>Whatsapp:
            </b> +52 (33) 1500 1469</a>
        </div>

      </div>
      <div class="col-md-8 ps-lg-5 pt-6 pb-6">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3733.6701858302367!2d-103.43829013137793!3d20.642296060381288!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428ac117279e817%3A0x38cdbd29311f1cb8!2sC.%20Volc%C3%A1n%20Vesubio%206271%2C%20Colli%20Urbano%2C%2045070%20Zapopan%2C%20Jal.!5e0!3m2!1ses!2smx!4v1722352195077!5m2!1ses!2smx"
          width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>

  <div style="background: #f4f6f9;">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="siguenos-img-container">
            <img src="../../assets/imagenes/inicio/tablet_siguenos.png" data-aos="fade-right" data-aos-delay="200">
          </div>
        </div>
        <div class="col-md-8 d-flex align-items-center pb-5 pb-md-0">
          <div class="mx-auto">
            <h3 class="color-azul mb-4" data-aos="left">Síguenos en Redes Sociales</h3>
            <div class="d-flex mb-3" data-aos="left">
              <img :src="`./inicio/icono_face.png`" class="me-4" style="width: 50px;">
              <a class="link-resultados-container"
                href="https://www.facebook.com/cdmilab?mibextid=LQQJ4d&rdid=Ow9KUL8SkYMUMtEo&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2FeGTGB4RwVMdMvcme%2F%3Fmibextid%3DLQQJ4d"
                target="_blank">
                @CDMI Laboratorios
              </a>
            </div>
            <div class="d-flex" data-aos="left">
              <img :src="`./inicio/icono_insta.png`" class="me-4" style="width: 50px;">
              <a class="link-resultados-container" href="https://www.instagram.com/laboratorioscdmi/" target="_blank">
                @Laboratorios CDMI
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- END MAIN -->
</template>

<script>
import { Carousel } from 'bootstrap';

export default {
  name: 'Inicio',
  data() {
    return {
      isVisible: false,
    }
  },
  setup() {

  },
  mounted() {
    //Para Carrusel
    this.inicializarCarousel();
    document.addEventListener('visibilitychange', this.handleVisibilityChange);

    // Para Animaciones
    // AOS.init({
    //   duration: 1000,
    //   offset:200,
    // })
  },
  beforeDestroy() {
    //Para Carusel
    document.removeEventListener('visibilitychange', this.handleVisibilityChange);
  },
  methods: {
    changeLinkActive(ruta) {
      console.log('se activo funcion changeactiveLink');
      this.$store.commit('changeActiveRoute', ruta); //Actualizar variable general (para footer)
    },
    //Para Carusel
    inicializarCarousel() {
      const carouselElement = document.querySelector('#carouselBanners');
      if (carouselElement) {
        const carousel = new Carousel(carouselElement);
        carousel.cycle();
      }
    },
    handleVisibilityChange() {
      if (document.visibilityState === 'visible') {
        this.inicializarCarousel();
      }
    },

  }
};
</script>

<style scoped>
.color-verde {
  color: #00a95e;
}

.analisis-container-1,
.analisis-container-2,
.analisis-container-3 {
  color: white;
  padding: 12px 0px;
  text-align: center;
  margin-bottom: 0px;
}

.analisis-container-1 p,
.analisis-container-2 p,
.analisis-container-3 p {
  margin-bottom: 0px;
  font-size: 20px;
}

.img-container-analisis {
  height: 300px;
  width: 100%;
  overflow: hidden;
}

@media(min-width:426px) {
  .img-container-analisis {
    height: 350px;
  }
}

@media(min-width:768px) {
  .img-container-analisis {
    height: 400px;
  }
}
@media(min-width:1024px) {
  .img-container-analisis {
    height: 450px;
  }
}
@media(min-width:1440px) {
  .img-container-analisis {
    height: 500px;
  }
}

.img-container-analisis img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: all 0.4s ease;
}

/* .img-container-analisis:hover img{
  transform: scale(1.1);
} */
.analisis-fhater-container {
  cursor: pointer;
  text-decoration: none;
  padding: 0;
}

.analisis-fhater-container p {
  color: white;
}

.analisis-fhater-container:hover img {
  transform: scale(1.1);
}


.analisis-container-1 {
  background: #00a95e;
}

.analisis-container-2 {
  background: #004207;
}

.analisis-container-3 {
  background: var(--color-tinto);
}

.img-resultados-container {
  overflow: hidden;
  display: inline-flex;
  height: 300px;
  margin: auto;
}

@media(min-width: 564px) {
  .img-resultados-container {
    height: 400px;
  }
}

@media(min-width: 768px) {
  .img-resultados-container {
    height: 450px;
  }
}

@media(min-width: 1024px) {
  .img-resultados-container {
    height: 500px;
  }
}

.img-resultados-container img {
  height: 100%;
  width: auto;
  object-fit: cover;
}

.fondo-gris {
  background: #f1f2f6;
}

.link-resultados-container {
  display: inline-block;
  padding-bottom: 7px;
  text-decoration: none;
  cursor: pointer;
  color: #8e9093;
  font-size: 24px;

}

.link-resultados-container:hover {
  border-bottom: solid #00a95e 2px;
  color: #00a95e;
}

.siguenos-img-container {
  height: 400px;
  overflow: hidden;
  padding: 50px 0px;
}

.siguenos-img-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.datos-contacto-container a,
p {
  color: #8e9093;
  text-decoration: none;
}

.datos-contacto-container a:hover {
  color: #00a95e;
}

.img-fondo-gris {
  background-image: url('../../assets/imagenes/fondo_gris.png');
  display: flex;
  justify-content: center;
}

.img-promocion-container {
  overflow: hidden;
  transition: all 0.3s ease;
  border-radius: 15px;
}

.img-promocion-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  cursor: pointer;
}

.img-promocion-container:hover {
  box-shadow: 0 0 15px rgba(0, 0, 0, .3);
  transform: translate(0px, -20px);
}
</style>