<template>
  <div class="container-fluid">
    <div class="row banner-agendarCita">
      <div class="col-7 col-md-7 d-flex align-items-center ">
        <h3 class="ms-auto pe-xlg-5" data-aos="fade-right">Formulario de Contacto <br><span class="color-azul">del
            paciente</span> </h3>
      </div>
      <div class="col-5 col-md-5 d-flex" style="height: 100%;">
        <img :src="`./agendarCita/banner.png`" class="me-auto mt-3 " data-aos="fade-left">
      </div>
    </div>
  </div>

  <div class="container my-5">
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="row">
          <div class="col-md-6 col-lg-4 pe-lg-3">
            <div class="input-contact-container mt-4">
              <label class="color-verde fw-bold d-block" for="nombre">Nombres <span class="color-rojo">*</span></label>
              <input v-model="infoCita.nombre" type="text" id="nombre">
            </div>
          </div>
          <div class="col-md-6 col-lg-5 pe-lg-3">
            <div class="input-contact-container mt-4">
              <label class="color-verde fw-bold d-block" for="apellidos">Apellidos <span
                  class="color-rojo">*</span></label>
              <input v-model="infoCita.apellidos" type="text" id="apellidos">
            </div>
          </div>

          <div class="col-sm-5 col-md-6 col-lg-3">
            <div class="input-contact-container mt-4">
              <label class="color-verde fw-bold d-block" for="fecha_nacimiento">Fecha Nacimiento <span
                  class="color-rojo">*</span></label>
              <input v-model="infoCita.fecha_nacimiento" type="date" id="fecha_nacimiento" onclick="this.showPicker()">
            </div>
          </div>
          <div class="col-sm-7 col-md-6 pe-lg-3">
            <div class="input-contact-container mt-4">
              <label class="color-verde fw-bold d-block" for="correo">Email <span class="color-rojo">*</span></label>
              <input v-model="infoCita.correo" type="text" id="correo">
            </div>
          </div>
          <div class="col-md-6 pe-lg-3">
            <div class="input-contact-container mt-4">
              <label class="color-verde fw-bold d-block" for="telefono">Teléfono<span
                  class="color-rojo">*</span></label>
              <div class="input-number-container">
                <input v-model="infoCita.lada" class="me-2" type="number" id="telefono" style="width: 25%;">
                <input v-model="infoCita.telefono" type="number">
              </div>
            </div>
          </div>
          <div class="col-md-6 pe-lg-3">
            <div class="input-contact-container mt-4">
              <label class="color-verde fw-bold d-block" for="calle">Domicilio <span class="color-rojo">*</span></label>
              <input v-model="infoCita.calle" type="text" id="calle">
            </div>
          </div>
          <div class="col-md-6 ps-lg-3">
            <div class="row">
              <div class="col-6 col-md-6 col-lg-4">
                <div class="input-contact-container mt-4">
                  <label class="color-verde fw-bold d-block" for="no_ext">No. Ext.<span
                      class="color-rojo">*</span></label>
                  <div class="input-number-container">
                    <input v-model="infoCita.no_ext" type="number" id="no_ext">
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-6 col-lg-4 ms-lg-4">
                <div class="input-contact-container mt-4">
                  <label class="color-verde fw-bold d-block" for="no_int">No. Int.</label>
                  <div class="input-number-container">
                    <input v-model="infoCita.no_int" type="text" id="no_int">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-6 pe-lg-3">
            <div class="input-contact-container mt-4">
              <label class="color-verde fw-bold d-block" for="colonia">Colonia <span class="color-rojo">*</span></label>
              <input v-model="infoCita.colonia" type="text" id="colonia">
            </div>
          </div>
          <div class="col-md-6 col-lg-6 pe-lg-3">
            <div class="row">
              <div class="col-4 col-md-6 col-lg-4">
                <div class="input-contact-container mt-4">
                  <label class="color-verde fw-bold d-block" for="cp">C.P.<span class="color-rojo">*</span></label>
                  <div class="input-number-container">
                    <input v-model="infoCita.cp" type="number" id="cp">
                  </div>
                </div>
              </div>
              <div class="col-8 col-md-6 col-lg-6 ms-lg-4">
                <div class="input-contact-container mt-4">
                  <label class="color-verde fw-bold d-block" for="municipio">Municipio<span
                      class="color-rojo">*</span></label>
                  <div class="input-number-container">
                    <input v-model="infoCita.municipio" type="text" id="municipio">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4">
            <div class="input-contact-container mt-4">
              <label class="color-verde fw-bold d-block" for="estado">Estado <span class="color-rojo">*</span></label>
              <input v-model="infoCita.estado" type="text" id="estado">
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 ms-lg-5">
            <div class="input-contact-container mt-4">
              <label class="color-verde fw-bold d-block" for="pais">País <span class="color-rojo">*</span></label>
              <input v-model="infoCita.pais" type="text" id="pais">
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-6 col-sm-6">
            <div class="input-contact-container mb-4">
              <label class="color-verde fw-bold d-block" for="calendario">Calendario <span
                  class="color-rojo">*</span></label>
              <input v-model="infoCita.fecha" type="date" id="calendario" @change="obtenerHorariosDisponibles"
                onclick="this.showPicker()">
            </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-xxl-2">
            <div class="input-contact-container mb-4">
              <label class="color-verde fw-bold d-block">Hora<span class="color-rojo">*</span></label>
              <!-- Select HORA -->
              <div class="time-container">
                <select class="" id="inputHora" v-model="infoCita.hora" @change="actualizarHora" ref="horaSelect">
                  <option v-for="hora in opciones.horas" :key="hora" :value="hora">{{ hora }}</option>
                </select> :
                <!-- Select MINUTOS -->
                <select class="" id="inputMinutos" v-model="infoCita.minutos">
                  <option v-for="minuto in opciones.minutos[infoCita.hora]" :key="minuto" :value="minuto">{{ minuto }}
                  </option>
                </select>
                <i class="fa-regular fa-clock color-verde fs-22" @click="activarSelectHora"></i>
              </div>
              <!-- <input type="time" id="inputHora" onclick="this.showPicker()"> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-lg-6">
            <div class="input-contact-container">
              <p class="color-verde fw-bold mb-0" for="">Estudios <span class="color-rojo">*</span></p>
              <div v-for="(estudio, index) in estudiosSeleccionados" :key="index" class="estudios-individual-container">
                <p class="m-0">{{ estudio.nombre }}</p>
                <i class="fa-solid fa-minus ms-auto" @click="eliminarEstudio(estudio)"></i>
              </div>
            </div>
            <!-- BUSCADOR -->
            <div class="agregar-estudio-container mt-3">
              <input v-model="inputBusqueda" class="" type="text" placeholder="Buscar un estudio"
                @input="resultadosBusqueda" @focus="mostrarResultados" @blur="ocultarResultados">
              <i class="fa-solid fa-plus"></i>
            </div>
            <p v-if="this.getEstudiosSeleccionados.length === 0" class="ps-4 color-rojo">Seleccione un estudios</p>
            <div v-if="inputBusqueda !== '' && resultadosVisibles" class="resultados-container" ref:resultados>
              <div v-if="estudiosFiltrados.length > 0" v-for="(estudio, index) in estudiosFiltrados" :key="index"
                class="resultados-individual-cotainer" @click="añadirEstudio(estudio)">
                <img :src="estudio.img ? `./iconos_estudios/${estudio.img}` : `./iconos_estudios/general.png`" alt="">
                <h2>{{ estudio.nombre }}</h2>
                <p>${{ estudio.precio }}</p>
              </div>
              <div v-else>
                <h2 class="text-center fs-20 color-gris mb-0">Sin resultados</h2>
              </div>
            </div>
            <!-- END BUSCADOR -->
          </div>
        </div>

        <div class="col-12">
          <div class="color-gris mt-5">
            <p class="color-verde fs-30 fw-600 mb-0">Total: <span class="color-gris fs-20">$ {{
              formatearPrecio(sumaTotal) }}</span></p>
            <p class="font-italic mb-1">Todos los precios incluyen IVA</p>
            <p class="mb-4">El costo total de sus estudios deberá ser cubierto en nuestras intalaciones.</p>
            <div class="checkbox-container mb-1">
              <input v-model="infoCita.condiciones" type="checkbox" id="condiciones">
              <label for="condiciones" class="ms-2">Acepto
                <router-link to="/avisoPrivacidad" class="link-condiciones">Aviso de Privacidad.</router-link>
                <span class="color-rojo">*</span>
              </label>
            </div>
            <div class="checkbox-container mb-4">
              <input v-model="infoCita.ofertas" type="checkbox" id="ofertas">
              <label for="ofertas" class="ms-2">Deseo recibir información general, ofertas y ventas
                especiales.</label>
            </div>

            <p class="font italic mb-4"><span class="color-rojo">*</span> Campos obligatorios.</p>
            <div class="d-flex">
              <button @click="agendarCita()" :disabled="!camposLlenos" class="btn-enviar mx-auto">
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
import { mapGetters } from 'vuex';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
  name: 'AgendarCita',
  data() {
    return {
      infoCita: {
        nombre: '',
        apellidos: '',
        fecha_nacimiento: '',
        correo: '',
        lada: '',
        telefono: '',
        calle: '',
        no_ext: '',
        no_int: '',
        colonia: '',
        cp: '',
        municipio: '',
        estado: '',
        pais: '',
        fecha: '',
        hora: '',
        minutos: '',
        condiciones: false,
        ofertas: false,
      },

      opciones: {
        horas: '',
        minutos: '',
      },

      estudios: [],
      inputBusqueda: '',
      estudiosFiltrados: [],
      resultadosVisibles: false,
    }
  },
  mounted() {
    this.fechaMinima();
    this.obtenerEstudios();
    if (this.infoCita.fecha) {
      this.obtenerHorariosDisponibles(); //Ejecuto esta funcion desde el mounted para que se muestren las horas y minutos disponibles si cambio de pagina y regreso al formulario
    }
  },
  created() {
    const infoAlmacenada = sessionStorage.getItem('infoCita');
    if (infoAlmacenada) {
      this.infoCita = JSON.parse(infoAlmacenada);
    }
  },
  beforeUnmount() {
  },
  computed: {
    //Ejecuto la funcion del store.js
    ...mapGetters(['getEstudiosSeleccionados']),

    //Obtengo los estudios seleccionados de store.js
    estudiosSeleccionados() {
      return this.getEstudiosSeleccionados;
    },
    camposLlenos() {
      return (
        this.infoCita.nombre !== '' &&
        this.infoCita.apellidos !== '' &&
        this.infoCita.fecha_nacimiento !== '' &&
        this.infoCita.correo !== '' &&
        this.infoCita.telefono !== '' &&
        this.infoCita.calle !== '' &&
        this.infoCita.no_ext !== '' &&
        this.infoCita.colonia !== '' &&
        this.infoCita.municipio !== '' &&
        this.infoCita.estado !== '' &&
        this.infoCita.pais !== '' &&
        this.infoCita.fecha !== '' &&
        this.infoCita.hora !== '' &&
        this.infoCita.minutos !== '' &&
        this.getEstudiosSeleccionados.length > 0 &&
        this.infoCita.condiciones == true
      );
    },
    sumaTotal() {
      return this.getEstudiosSeleccionados.reduce((total, estudio) => {
        const precio = parseFloat(estudio.precio) || 0; //Convertir la cadena de texto a numero
        return total + precio;
      }, 0);
    },
  },
  methods: {
    guardarInfoForm() {
      sessionStorage.setItem('infoCita', JSON.stringify(this.infoCita));
    },

    async obtenerHorariosDisponibles() {
      if (this.infoCita.fecha) {
        try {
          const fecha = new Date(this.infoCita.fecha);
          const response = await axios.get('/disponibilidad-horario', {
            params: { fecha: fecha },
          });

          const horariosOcupados = response.data; //horariosOcupados es un objeto donde las claves son las hora y los valores son array de minutos ocupados para esa hora.
          //Definir el rango de hora y munutos
          const rangoHoras = Array.from({ length: 11 }, (_, i) => String(i + 7).padStart(2, '0')); //Genera un array de horas desde las 07 hasta las 14 y las convierte a texto
          const rangoMinutos = ['00', '15', '30', '45'];

          //Calcular horas disponibles
          const horasDisponibles = rangoHoras.filter(hora => { //filter crear un nuevo array con los elementos del array original que cumplen cierta condicion, hora es el valor actual de la iteracion de array "rangoHoras"
            return !horariosOcupados.hasOwnProperty(hora) ||  //hasOwnProperty verifica si el objeto(horariosOcupados) no tiene una propiedad con cierto nombre(en este caso: hora)
              horariosOcupados[hora].length < rangoMinutos.length; //Verifica si el numero de minutos ocupados es menor que el total de minutos disponibles
          });

          // Calcular minutos disponibles por cada hora
          const minutosDisponiblesPorHora = {};
          for (const hora of horasDisponibles) { //Se itera el array de horasDisponibles
            if (horariosOcupados.hasOwnProperty(hora)) { //Si la hora iterada se encuentra en las horas ocupadas se calculan los minutos disponibles
              minutosDisponiblesPorHora[hora] = rangoMinutos.filter(minuto => !horariosOcupados[hora].includes(minuto)); //Se crea un array solo con los minutos que no estan en el array de la hora acutal en el array "horariosOcupados", "minuto" corresponde a cada minuto del array "rangoMinutos", "horariosOCupados[hora]" obtiene el array de minutos ocupados para la hora actual, "includes(minuto)" verifica si el minuto esta en el array de minutos ocupados de la hora actual.
            } else {
              minutosDisponiblesPorHora[hora] = [...rangoMinutos]; // Copiar el array
            }
          }

          this.opciones.horas = horasDisponibles;
          this.opciones.minutos = minutosDisponiblesPorHora;

          // Resetear horas y minutos seleccionados
          this.infoCita.hora = this.opciones.horas.length ? this.opciones.horas[0] : '';
          this.infoCita.minutos = this.infoCita.hora ? this.opciones.minutos[this.infoCita.hora][0] : '';

        } catch (error) {
          console.error('Error al obtener los horarios disponibles: ', error);
        }
      }
    },
    actualizarHora() {
      if (this.infoCita.hora) {
        this.infoCita.minutos = this.opciones.minutos[this.infoCita.hora][0];
      }
    },
    async obtenerEstudios() {
      try {
        const response = await this.$axios.get('/obtenerEstudiosTodos');
        this.estudios = response.data;
      } catch {
        console.error('Error obteniendo los estudios para el NavBar: ', error);
      }
    },
    resultadosBusqueda() {
      const parametroBusqueda = this.inputBusqueda.toLocaleLowerCase();

      this.estudiosFiltrados = this.estudios.filter(estudio =>
        estudio.codigo.toLocaleLowerCase().includes(parametroBusqueda) ||
        estudio.nombre.toLocaleLowerCase().includes(parametroBusqueda) ||
        estudio.sinonimo.toLocaleLowerCase().includes(parametroBusqueda)
      );
    },
    añadirEstudio(estudio) {
      this.$store.commit('añadirEstudio2', estudio)
      this.inputBusqueda = '';
    },
    eliminarEstudio(estudio) {
      this.$store.commit('eliminarEstudio', estudio);
    },

    //PARA MANEJAR VISIBILIDAD DE RESULTADOS
    mostrarResultados() {
      this.resultadosVisibles = true;
    },
    ocultarResultados() {
      setTimeout(() => {
        this.resultadosVisibles = false;
      }, 100)
    },
    async agendarCita() {
      try {
        //Validacion Correo
        if (!this.correoValido(this.infoCita.correo)) {
          await Swal.fire({
            icon: "warning",
            title: "Correo Electrónico Inválido",
            text: "Por favor, ingrese un correo electrónico válido.",
            confirmButtonText: 'Aceptar',
            allowOutsideClick: false,
          });
          return; // Salir del método si el correo electrónico no es válido
        }
        //Alerta Enviando...
        Swal.fire({
          title: 'Agendando Cita...',
          text: 'Por favor espere.',
          allowOutsideClick: false,
          showConfirmButton: false,
          willOpen: () => {
            Swal.showLoading();
          }
        });
        //Solicitud al BackEnd (envio del correo)
        const response = await axios.post('/agendarcita2', {
          infoCita: this.infoCita, //Necesito enviar los datos en un array anidado para que laravel los pueda recepcionar
          estudios: this.getEstudiosSeleccionados
        });
        //Obtener el folio y el PDF de la respuesta
        const folio = response.data.folio;
        const pdfBase64 = response.data.pdf;

        // Crear una URL para el PDF y abrirlo en una nueva ventana
        const pdfBlob = new Blob([new Uint8Array(atob(pdfBase64).split("").map(char => char.charCodeAt(0)))], { type: 'application/pdf' });
        const url = window.URL.createObjectURL(pdfBlob);
        window.open(url, '_blank'); // Abre el PDF en una nueva ventana

        //Alerta Confirmacion
        const result = await Swal.fire({
          icon: "success",
          title: "Cita Agendada",
          html: `Folio: <strong>${folio}</strong>.<br>Se ha generado un PDF con los detalles de su cita, el cual se ha mostrado en una nueva ventana, asegurse de descargarlo. <br> Además, se ha enviado un correo con los detalles de la cita a: <strong> ${this.infoCita.correo} </strong>`,
          confirmButtonText: 'Aceptar',
          allowOutsideClick: false,
          showConfirmButton: true, // No mostrar botón
        })
        if (result.isConfirmed) {
          sessionStorage.removeItem('infoCita'); //Se elimna la sessionStorage
          this.infoCita = ''; //Resetear formulario
          window.location.href = '/'; //Se redirige al inicio
        }
      } catch (error) {
        // Manejo de errores
        console.log('Error:', error); // Imprimir el error completo
        if (error.response) {
          // Imprimir los datos de la respuesta si están disponibles
          console.log('Response Data:', error.response.data);

          // Mostrar detalles del error devuelto por el backend en la consola
          console.log('Error Message:', error.response.data.message);
          console.log('Error Details:', error.response.data.error);
          console.log('Error in File:', error.response.data.file);
          console.log('Error on Line:', error.response.data.line);
        } else if (error.request) {
          console.log('Request Error:', error.request); // Imprimir la solicitud si hay error en la solicitud
        } else {
          console.log('General Error:', error.message); // Imprimir el mensaje de error general
        }
      }
    },
    correoValido(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(email);
    },

    //Funcion para calendario, solo permite seleccionar un dia despues de hoy
    fechaMinima() {
      const input = document.getElementById('calendario');

      const fechaActual = new Date();
      const fechaMañana = new Date(fechaActual);
      fechaMañana.setDate(fechaActual.getDate() + 1);

      const año = fechaMañana.getFullYear();
      const mes = String(fechaMañana.getMonth() + 1).padStart(2, '0');
      const dia = String(fechaMañana.getDate()).padStart(2, '0');

      const fechaMinima = `${año}-${mes}-${dia}`;

      input.setAttribute('min', fechaMinima);
    },

    formatearPrecio(precio) {
      const numero = parseFloat(precio); //Se convierte el precio a decimal
      return numero.toLocaleString('es-MX', { //Se formatea a moneda mexicana
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },

  },
  beforeRouteLeave(to, from, next) {
    this.guardarInfoForm(); //Esto es para que antes de viajar a otra ruta se ejecute esta funcion
    next();
  }
};
</script>

<style scoped>
.estudios-individual-container {
  padding: 5px 0px 5px 20px;
  border: 2px solid #00a95e;
  border-radius: 30px;
  display: flex;
  margin: 0 0 10px 0;
}

.agregar-estudio-container {
  display: flex;
  padding: 5px 0px 5px 20px;
  border: 2px solid #00a95e;
  border-radius: 30px;
}

.agregar-estudio-container i {
  margin: auto 0px;
  color: #00a95e;
  font-size: 24px;
  padding: 0px 20px;
}

.agregar-estudio-container input {
  border: none;
  width: 100%;
}

.agregar-estudio-container input:focus {
  outline: none;
}

.estudios-individual-container i {
  margin: auto 0px;
  color: #00a95e;
  font-size: 24px;
  cursor: pointer;
  padding: 0px 20px;
}

.time-container {
  display: flex;
  align-items: center;
  justify-content: space-around;
  border: 2px solid #00a95e;
  border-radius: 30px;
  transition: all 0.3s ease;
}

.time-container select {
  width: 30%;
  border: none;
  padding: 6px 0px;
  border-radius: 50%;
}

.resultados-container {
  margin-top: 20px;
  border-radius: 15px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  padding: 10px;
  max-height: 50vh;
  overflow: auto;
}

.resultados-individual-cotainer {
  display: flex;
  align-items: center;
  margin-bottom: 5px;
  transition: all 0.3s ease;
  padding-right: 5px;
}

.resultados-individual-cotainer:hover {
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

.resultados-individual-cotainer img {
  width: 10%;
  margin-right: 30px;
}

.resultados-individual-cotainer h2 {
  font-size: 20px;
  margin-bottom: 0px;
}

.resultados-individual-cotainer p {
  margin-bottom: 0px;
  margin-left: auto;

}

.width-adaptable {
  width: 100%;
}


.link-condiciones {
  text-decoration: none;
  color: var(--color-verde);
  transition: all 0.3 ease;
}


@media(min-width:992px) {
  .width-adaptable {
    width: 75%;
  }
}

.banner-agendarCita {
  background-image: url('../../assets/imagenes/fondo_gris.png');
  background-size: cover;
  background-position: center;
  overflow: hidden;
  height: 250px;
  box-shadow: 0 0px 10px rgb(0, 0, 0, 0.3);
}

.banner-agendarCita img {
  height: 110%;
  width: auto;
  object-fit: cover;
}

.banner-agendarCita h3 {
  font-size: 1.1rem;
  text-align: center;
  color: var(--color-verde);
  font-weight: bold;
}

@media(min-width: 576px) and (max-width: 1024px) {
  .banner-agendarCita {
    height: 400px;
  }

  .banner-agendarCita h3 {
    font-size: 2.5rem;
  }
}

@media(min-width: 1025px) {
  .banner-agendarCita {
    height: 550px;
  }

  .banner-agendarCita h3 {
    font-size: 3rem;
  }
}
</style>