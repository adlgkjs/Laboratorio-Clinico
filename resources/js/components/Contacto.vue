<template>
  <div class="container-fluid">
    <div class="row banner-contacto">
      <div class="col-6 d-flex" style="height: 100%;">
        <img :src="`./contactanos/banner.png`" class="ms-auto mt-3" data-aos="fade-right">
      </div>
      <div class="col-6 d-flex align-items-center">
        <h3 class="me-auto" data-aos="fade-left">Contáctanos</h3>
      </div>
    </div>
  </div>

  <div class="container my-5">
    <div class="row">
      <div class="col-lg-6 color-gris mx-auto text-center" data-aos="fade-up" data-aos-offset="200">
        <p class="">
          <a href="https://maps.app.goo.gl/xQo2dqs8VdaCV5gg7" target="_blank" class="link-dom">
            <b>Dirección: </b>Volcán Vesubio 6193, Col. El Colli Urbano, <br>C.P. 45070, Zapopan, Jalisco, México.
          </a>
        </p>
        <p class="fw-bold mt-5 mb-1">Horario de Atención:</p>
        <p class="mb-1">Lunes a Viernes de 07:00 a 18:00 hrs.</p>
        <p class="mb-1">Sábado de 07:00 a 14:00 hrs.</p>
        <p class="mb-1">
          <a href="tel:+523344453900" target="_blank" class="link-tel"><b>Tel: </b>+52 (33) 4445 3900</a>
        </p>
        <p class="mb-1">
          <a href="https://wa.me/523315001469?text= Hola me comunico desde su sitio web," target="_blank"
            class="link-whats"><b>Whatsapp: </b> +52 (33) 1500 1469</a>
        </p>
      </div>
    </div>
  </div>

  <div class="" style="background: #eeeeee;">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 pe-lg-5">
          <div class="input-contact-container mt-4">
            <label class="color-verde fw-bold d-block" for="nombre">Nombres <span class="color-rojo">*</span></label>
            <input v-model="infoContacto.nombre" type="text" id="nombre" tabindex="1">
          </div>
        </div>
        <div class="col-md-6 col-lg-5 pe-lg-5">
          <div class="input-contact-container mt-4">
            <label class="color-verde fw-bold d-block" for="apellidos">Apellidos <span
                class="color-rojo">*</span></label>
            <input v-model="infoContacto.apellidos" type="text" id="apellidos" tabindex="2">
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 pe-lg-5">
          <div class="input-contact-container mt-4">
            <label class="color-verde fw-bold d-block" for="correo">Email <span class="color-rojo">*</span></label>
            <input v-model="infoContacto.correo" type="text" id="correo" tabindex="3">
          </div>
        </div>
        <div class="col-md-6 col-lg-5 pe-lg-5">
          <div class="input-contact-container mt-4">
            <label class="color-verde fw-bold d-block" for="telefono">Teléfono<span class="color-rojo">*</span></label>
            <div class="input-number-container">
              <input v-model="infoContacto.lada" class="me-2" type="number" id="telefono" style="width: 20%;"
                tabindex="4">
              <input v-model="infoContacto.telefono" type="number" tabindex="5">
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 pe-lg-5">
          <div class="input-contact-container mt-4">
            <label class="color-verde fw-bold d-block" for="asunto">Asunto</label>
            <input v-model="infoContacto.asunto" type="text" id="asunto" tabindex="6">
          </div>
          <div class="input-contact-container mt-4">
            <label class="color-verde fw-bold d-block" for="mensaje">Mensaje <span class="color-rojo">*</span></label>
            <textarea v-model="infoContacto.mensaje" id="mensaje" tabindex="7"></textarea>
          </div>
        </div>


        <div class="col-md-6 col-lg-5 ps-lg-5">
          <!-- Aviso de Privacidad -->
          <div class="checkbox-container mt-4 justify-content-center justify-content-md-start">
            <input v-model="infoContacto.avisoPrivacidad" type="checkbox" id="avisoPrivacidad" tabindex="8">
            <label for="avisoPrivacidad" class="ms-2 color-gris">Acepto
              <router-link to="/avisoPrivacidad" class="link-condiciones">Aviso de Privacidad.</router-link>
              <span class="color-rojo fw-bold">*</span>
            </label>
          </div>

          <div class="input-contact-container mt-4">
            <div class="input-number-container justify-content-center justify-content-md-start">
              <div id="recaptcha-container" class="g-recaptcha" data-sitekey="6LdEADUqAAAAABPKVxUgoIgFaWzgC8FHjQUZxS8v"
                @load="onLoadRecaptcha">
              </div>
              <input type="hidden" v-model="recaptchaToken">
            </div>
          </div>
          <div class="pt-md-4">
            <p class="color-gris font-italic t-center text-md-left"><span class="color-rojo">*</span>Campos obligatorios
            </p>
            <div class="d-flex justify-content-center justify-content-md-start">
              <button :disabled="!camposLlenos || !recaptchaToken" class="btn-enviar" @click="enviarCorreoContacto()"
                tabindex="8">
                ENVIAR
                <i class="fa-solid fa-arrow-right ms-2"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
  name: 'Contacto',
  data() {
    return {
      infoContacto: {
        nombre: '',
        apellidos: '',
        correo: '',
        lada: '',
        telefono: '',
        asunto: '',
        mensaje: '',
      },
      recaptchaToken: '',
    }
  },
  mounted() {
    if (window.grecaptcha) {
      this.onLoadRecaptcha(); //Si el grecaptcha esta totalmente cargado ejecuta la funcion
    } else {
      const intervalId = setInterval(() => { //setInterval ejecuta este codigo hasta que se entra en el if(hasta que el grecaptcha esta totalmente cargado) y clearInterval lo detiene.
        if (window.grecaptcha) {
          clearInterval(intervalId);
          this.onLoadRecaptcha();
        }
      }, 1000);
    }
  },
  computed: {
    camposLlenos() {
      return (
        this.infoContacto.nombre !== '' &&
        this.infoContacto.apellidos !== '' &&
        this.infoContacto.correo !== '' &&
        this.infoContacto.lada !== '' &&
        this.infoContacto.telefono !== '' &&
        this.infoContacto.mensaje !== '' &&
        this.infoContacto.avisoPrivacidad === true

      );
    },
  },
  methods: {
    onLoadRecaptcha() {
      window.grecaptcha.render('recaptcha-container', {
        sitekey: '6LdEADUqAAAAABPKVxUgoIgFaWzgC8FHjQUZxS8v',
        callback: (token) => {
          this.recaptchaToken = token;
        }
      });
    },
    async enviarCorreoContacto() {
      try {
        //Alerta de Carga
        Swal.fire({
          title: 'Envido mensaje...',
          text: 'Por favor espere.',
          allowOutsideClick: false,
          showConfirmButton: false,
          willOpen: () => {
            Swal.showLoading();
          }
        });
        //Solicitud al BackEnd (envio del correo)
        await axios.post('/enviarCorreoContacto', {
          infoContacto: this.infoContacto,
          recaptcha_token: this.recaptchaToken,
        });
        //Se resetea el formulario
        this.infoContacto = {};
        //Alerta de Exito
        Swal.fire({
          icon: "success",
          title: "Mensaje enviado",
          text: 'Nos comunicaremos en breve.',
          timer: 3000, // Duración de 2 segundos
          showConfirmButton: false, // No mostrar botón
        })
      } catch (error) {
        if (error.response) {
          //Alerta de error
          Swal.fire({
            icon: "error",
            title: "Error al enviar el correo",
            text: "Inténtelo más tarde",
            showConfirmButton: true,
          });
        }
      }
    },
  },

}

</script>

<style scoped>
.link-tel,
.link-whats,
.link-dom {
  color: var(--color-gris);
  text-decoration: none;
}

.link-tel:hover,
.link-whats:hover,
.link-dom:hover {
  color: var(--color-verde)
}

.tablita-1:hover,
.tablita-2:hover {
  transform: scale(1.2);
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

.banner-contacto {
  background-image: url('../../assets/imagenes/fondo_gris.png');
  background-size: cover;
  background-position: center;
  overflow: hidden;
  height: 250px;
  box-shadow: 0 0px 10px rgb(0, 0, 0, 0.3);
}

.banner-contacto img {
  height: 100%;
  width: auto;
  object-fit: cover;
}

.banner-contacto h3 {
  font-size: 1.8rem;
  text-align: center;
  color: var(--color-verde);
  font-weight: bold;
}

@media(min-width: 576px) and (max-width: 1024px) {
  .banner-contacto {
    height: 400px;
  }

  .banner-contacto h3 {
    font-size: 2.5rem;
  }
}

@media(min-width: 1025px) {
  .banner-contacto {
    height: 550px;
  }


  .banner-contacto h3 {
    font-size: 3rem;
  }
}
</style>