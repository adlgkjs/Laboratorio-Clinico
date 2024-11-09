<template>
  <div class="container-fluid">
    <div class="row justify-content-center" style="height: 100vh;">
      <div class="col-md-8 col-lg-6 col-xl-4 d-flex align-items-center">
        <div style="width: 100%;">
          <div class="logo-container mx-auto mb-4">
            <img :src="`./logo_CDMI.png`" class="" alt="Logo">
          </div>
          <form @submit.prevent="enviarFormulario">
            <div class="form-container py-4 px-4 px-md-5 my-auto">
              <div class="input-contact-container mb-4">
                <label class="color-verde fw-bold d-block text-center" for="nombre">Usuario</label>
                <input v-model="data.usuario" type="text" id="nombre">
              </div>
              <div class="input-contact-container mb-4">
                <label class="color-verde fw-bold d-block text-center" for="contraseña">Contraseña</label>
                <input v-model="data.contraseña" type="password" id="contraseña">
              </div>
              <div class="btn-container">
                <button :disabled="!camposLlenos" class="btn-enviar px-5 fw-bold" type="submit">
                  Entrar
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
// import { mapActions } from 'vuex';
// import { useRouter } from 'vue-router';
// import { useStore } from 'vuex';

export default {
  name: 'Login',
  data() {
    return {
      data: {
        usuario: '',
        contraseña: '',
      },
    }
  },
  computed: {
    camposLlenos() {
      return (
        this.data.usuario !== '' &&
        this.data.contraseña !== ''
      );
    }
  },
  methods: {

    async enviarFormulario() {
      try {
        //Alerta Cargando...
        Swal.fire({
          title: 'Cargando...',
          allowOutsideClick: false,
          showConfirmButton: false,
          willOpen: () => {
            Swal.showLoading();
          }
        });
        //Solicitud al BackEnd (envio del correo)
        const response = await axios.post('/login', this.data);
        if (response.status === 200) {
          this.$store.commit('setAuth', true); //Ejecuto funcion setAut del store.js
          Swal.close(); // Cerrar la alerta de carga si hay un error
          this.$router.push('/panelAdministracion'); //Enviar a dashboard
        }

      } catch (error) {
        Swal.close(); // Cerrar la alerta de carga si hay un error

        if (error.response) {
          if (error.response.status === 401) {
            //Error Contraseña
            if (error.response.data.message === 'Credenciales incorrectas') {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Credenciales Incorrectas',
                timer: 2000
              });
              //Error Usuario
            }
            //Error General
          }else if(error.response.status === 419){
            console.log('Error con toket de Laravel');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Ocurrio un problema. Inténtelo más tarde.',
              timer: 2000
            });
          }
          //Error de Conexion
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error de Conexión. Por favor, verifique su conexión a Internet.',
            timer: 2000
          });
        }

        // Manejo de errores
        console.log('Error:', error); // Imprimir el error completo
        if (error.response) {
          console.log('Response Data:', error.response.data); // Imprimir datos de la respuesta si están disponibles
        } else if (error.request) {
          console.log('Request Error:', error.request); // Imprimir la solicitud si hay error en la solicitud
        } else {
          console.log('General Error:', error.message); // Imprimir el mensaje de error general
        }
      }
    }
  },

};
</script>

<style scoped>
.container {
  background: rgb(250, 250, 250);
}


.logo-container {
  width: 300px;
  overflow: hidden;
  /* margin: 5rem 0 1rem 0; */

}

.logo-container img {
  width: 100%;
  height: auto;
  object-fit: cover;
}

.form-container {
  box-shadow: 0 0 .5rem rgba(0, 0, 0, 0.2);
  border-radius: 10px;
  /* background: rgb(247, 247, 247); */
}

.btn-container {
  display: flex;
  justify-content: center;
}
</style>