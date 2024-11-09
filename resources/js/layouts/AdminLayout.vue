<template>
  <div>
    <!-- TOPNAVBAR -->
    <nav class="navbar navbar-expand-md py-0 fixed-top">
      <div class="container-fluid">
        <router-link class="navbar-brand ms-lg-5 py-0" to="/panelAdministracion">
          <img :src="`./logo_CDMI.png`" alt="Logo">
        </router-link>

        <div class="mx-auto">
          <button type="button" class="btn btn-success d-md-none" data-bs-toggle="modal" data-bs-target="#crearCita">
            <i class="fa-solid fa-plus"></i>
            Nueva Cita
          </button>
        </div>

        <div class="">
          <button class="navbar-toggler" type="button" @click="toggleNavbar" @blur="ocultarNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>

        <!-- NAVBAR COLLAPSE -->
        <div :class="['collapse', 'navbar-collapse', { show: isNavbarOpen }]">
          <ul class="navbar-nav mb-2 mb-lg-0 align-items-center ms-auto mt-3 mt-md-0 me-md-3">
            <button type="button" class="btn btn-success me-4 d-none d-md-block" @click="abrirModalNuevaCita">
              <i class="fa-solid fa-plus"></i>
              Nueva Cita
            </button>
            <li class="nav-item link-navbar" @click="logout()">
              <i class="fa-solid fa-right-from-bracket fs-5 pe-2"></i>
              <a class="fs-5">Log out</a>
            </li>
          </ul>
        </div>
        <!-- END NAVBAR COLLAPSE -->
      </div>
    </nav>
    <!-- END TOP NAVBAR -->

    <!-- SIDEBAR -->
    <div :class="['barra-verde', { 'barra-visible': !isSideBarOpen }]">
      <button @click="toggleSidebar" class="btn-toggle-sidebar">
        <i class="fa-solid fa-angle-right"></i>
      </button>
    </div>

    <div :class="['sidebar-container', { 'sidebar-open': isSideBarOpen }]">
      <div class="menu-lateral-container">
        <i class="fa-solid fa-x fs-5 cursor-pointer ms-auto pe-2 pt-2" @click="toggleSidebar"></i>
        <div class="">
          <div class="calendar-container p-2 pt-4">
            <!-- Calendario -->
            <v-date-picker v-model="selectedDay" is-inline :attributes="attrs" color="green"
              @dayclick="filtrarCitasPorFecha" />
          </div>
        </div>
      </div>
    </div>
    <!-- END SIDEBAR -->

    <div :class="['main-container', { 'padding-izquierdo': isSideBarOpen }]">
      <!-- <router-view /> -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="mx-auto text-center">
          <div v-if="selectedDay" class="fecha-verde">
            <h2 class="mb-0 fs-3">{{ formatearFecha(selectedDay) }}</h2>
          </div>
          <div v-else class="fecha-roja">
            <h2 class="mb-0 fs-3">Seleccione una fecha</h2>
          </div>
        </div>
        <div class="">
          <button type="button" class="btn btn-secondary" @click="descargarPrecios()"> Descargar Precios </button>
        </div>
      </div>
      <hr>
      <div class="">
        <div v-if="citasFiltradas.length === 0 && selectedDay">
          <div class="contenedor-amarillo d-flex">
            <h3 class="text-center mt-5">Agenda Vacia</h3>
          </div>
          <div class="calendar-icon-container">
            <i class="fa-regular fa-calendar-xmark"></i>
          </div>
        </div>
        <div v-else-if="citasFiltradas.length > 0 && selectedDay">
          <DataTable :value="citasFiltradas" stripedRows>
            <Column header="Hora" sortable>
              <template #body="{ data }">
                {{ formatearHora(data.fecha_hora) }}
              </template>
            </Column>
            <Column field="compra.folio" header="Folio" sortable></Column>
            <Column field="paciente.nombre" header="Nombre" sortable></Column>
            <Column field="paciente.apellidos" header="Apellidos" sortable></Column>
            <Column field="compra.total_compra" header="Compra" sortable>
              <template #body="{ data }">
                {{ formatearPrecio(data.compra.total_compra) }}
              </template>
            </Column>
            <Column header="Acciones">
              <template #body="{ data }">
                <Button severity="info" icon="pi pi-eye" class="btn-eye2 me-2" @click="mostrarInfoDetalle(data)" />
                <Button icon="pi pi-file-pdf" class="btn-eye2 btn-success me-2" @click="generarPDF(data)" />
                <Button severity="danger" icon="pi pi-trash" class="btn-trash" @click="eliminarCita(data)" />
              </template>
            </Column>
          </DataTable>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL CREAR -->
  <div class="modal fade" id="crearCita" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header ps-4">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid pt-2">
            <div class="row">
              <div class="col-md-6 col-lg-4 mt-lg-0">
                <div class="input-container">
                  <label for="nombre">Nombre <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.nombre }" @blur="validarCampo('nombre')" type="text"
                    id="nombre" v-model="nuevaCita.nombre">
                  <p v-if="camposInteraccion.nombre && !nuevaCita.nombre" class="mb-0 fs-14 color-rojo">Campo requerido
                  </p>
                </div>
              </div>
              <div class="col-md-6 col-lg-5 mt-2 mt-md-0">
                <div class="input-container">
                  <label for="apellidos">Apellidos <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.apellidos }" @blur="validarCampo('apellidos')"
                    type="text" id="apellidos" v-model="nuevaCita.apellidos">
                  <p v-if="camposInteraccion.apellidos && !nuevaCita.apellidos" class="mb-0 fs-14 color-rojo">Campo
                    requerido</p>
                </div>
              </div>
              <div class="col-md-6 col-lg-3 mt-2 mt-lg-0">
                <div class="input-container">
                  <label for="fecha_nacimiento">Fecha Nacimiento <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.fecha_nacimiento }" @blur="validarCampo('fecha_nacimiento')"
                    type="date" id="fecha_nacimiento" v-model="nuevaCita.fecha_nacimiento">
                  <p v-if="camposInteraccion.fecha_nacimiento && !nuevaCita.fecha_nacimiento" class="mb-0 fs-14 color-rojo">Campo
                    requerido</p>
                </div>
              </div>
              <div class="col-md-6 mt-2">
                <div class="input-container">
                  <label for="telefono">Telefono <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.telefono }" @blur="validarCampo('telefono')"
                    type="number" id="telefono" v-model="nuevaCita.telefono">
                  <p v-if="camposInteraccion.telefono && !nuevaCita.telefono" class="mb-0 fs-14 color-rojo">Campo
                    requerido</p>
                </div>
              </div>
              <div class="col-md-6 mt-2">
                <div class="input-container">
                  <label for="correo">Email</label>
                  <input type="text" id="correo" v-model="nuevaCita.correo">
                </div>
              </div>

            </div>

            <div class="row mt-2">
              <!-- <div class="col-md-4">
                <div class="input-container">
                  <label for="calle">Calle <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.calle }" @blur="validarCampo('calle')" type="text"
                    id="calle" v-model="nuevaCita.calle">
                  <p v-if="camposInteraccion.calle && !nuevaCita.calle" class="mb-0 fs-14 color-rojo">Campo requerido
                  </p>
                </div>
              </div>
              <div class="col-md-2">
                <div class="input-container">
                  <label for="no_ext">No. Ext <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.no_ext }" @blur="validarCampo('no_ext')" type="number"
                    id="no_ext" v-model="nuevaCita.no_ext">
                  <p v-if="camposInteraccion.no_ext && !nuevaCita.no_ext" class="mb-0 fs-14 color-rojo">Campo requerido
                  </p>
                </div>
              </div>
              <div class="col-md-2">
                <div class="input-container">
                  <label for="no_int">No. Int</label>
                  <input type="text" id="no_int" v-model="nuevaCita.no_int">
                </div>
              </div> -->
            </div>

            <!-- <div class="row mt-2">
              <div class="col-md-5">
                <div class="input-container">
                  <label for="colonia">Colonia <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.colonia }" @blur="validarCampo('colonia')" type="text"
                    id="colonia" v-model="nuevaCita.colonia">
                  <p v-if="camposInteraccion.colonia && !nuevaCita.colonia" class="mb-0 fs-14 color-rojo">Campo
                    requerido
                  </p>
                </div>
              </div>
              <div class="col-md-5">
                <div class="input-container">
                  <label for="municipio">Municipio <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.municipio }" @blur="validarCampo('municipio')"
                    type="text" id="municipio" v-model="nuevaCita.municipio">
                  <p v-if="camposInteraccion.municipio && !nuevaCita.municipio" class="mb-0 fs-14 color-rojo">Campo
                    requerido</p>
                </div>
              </div>
              <div class="col-md-2">
                <div class="input-container">
                  <label for="cp">C.P.</label>
                  <input type="numer" id="cp" v-model="nuevaCita.cp">
                </div>
              </div>
            </div> -->
            <!-- <div class="row mt-2">
              <div class="col-md-3">
                <div class="input-container">
                  <label for="estado">Estado <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.estado }" @blur="validarCampo('estado')" type="text"
                    id="estado" v-model="nuevaCita.estado">
                  <p v-if="camposInteraccion.estado && !nuevaCita.estado" class="mb-0 fs-14 color-rojo">Campo requerido
                  </p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-container">
                  <label for="pais">País <span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidos.pais }" @blur="validarCampo('pais')" type="text"
                    id="pais" v-model="nuevaCita.pais">
                  <p v-if="camposInteraccion.pais && !nuevaCita.pais" class="mb-0 fs-14 color-rojo">Campo requerido</p>
                </div>
              </div>
            </div> -->
            <hr>

            <div class="row">
              <div class="col-md-6">
                <h4 class="fs-5">Cita</h4>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-container">
                      <label for="dia">Día <span class="color-rojo">*</span></label>
                      <input v-model="nuevaCita.fecha" @change="HorariosDisNuevacita()" type="date" id="dia"
                        onclick="this.showPicker()" class="fechaMinima">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-container">
                      <label for="hora">Hora <span class="color-rojo">*</span></label>
                      <div class="time-container">
                        <select class="" id="inputHora" v-model="nuevaCita.hora" @change="actualizarHoraNuevaCita">
                          <option v-for="hora in opciones.horas" :key="hora" :value="hora">{{ hora }}</option>
                        </select> :
                        <!-- Select MINUTOS -->
                        <select class="" id="inputMinutos" v-model="nuevaCita.minutos">
                          <option v-for="minuto in opciones.minutos[nuevaCita.hora]" :key="minuto" :value="minuto">
                            {{
                              minuto }}
                          </option>
                        </select>
                        <i class="fa-regular fa-clock ms-auto color-verde fs-22"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="input-container mt-3">
                  <h4><span class="color-verde">Total:</span> <span class="fs-5">{{
                    formatearPrecio(sumaTotal) }}</span></h4>
                </div>
              </div>

              <div class="col-md-6">
                <h4 class="fs-5 mb-4">Estudios</h4>
                <!-- Buscador -->
                <div class="search-container">
                  <i class="fa-solid fa-magnifying-glass" for="buscar"></i>
                  <input v-model="inputBusqueda" @input="resultadosBusqueda" @focus="mostrarResultados"
                    @blur="ocultarResultados" type="text" placeholder="Buscar.." id="buscar">

                  <!--  -->
                  <div v-if="inputBusqueda !== '' && resultadosVisibles" class="resultados-container">
                    <!-- Resultados -->
                    <div v-if="estudiosFiltrados.length > 0" v-for="(estudio, index) in estudiosFiltrados" :key="index"
                      class="resultados-individual-cotainer" @click="añadirEstudio(estudio)">
                      <img :src="estudio.img ? `./iconos_estudios/${estudio.img}` : `./iconos_estudios/general.png`">
                      <h2>{{ estudio.nombre }}</h2>
                      <p>${{ estudio.precio }}</p>
                    </div>
                    <div v-else>
                      <h2 class="text-center fs-20 color-gris mb-0">Sin resultados</h2>
                    </div>
                  </div>
                </div>
                <p v-if="this.estudiosSeleccionados.length === 0" class="ps-4 color-rojo">Seleccione un estudios</p>

                <!-- End Buscador -->
                <!-- Estudios Seleccionados -->
                <div v-for="(estudio, index) in estudiosSeleccionados" :key="index" class="estudio-container mt-2">
                  <p class="ps-2 mb-0">{{ estudio.nombre }} - ${{ estudio.precio }}</p>
                  <i class="fa-solid fa-minus ms-auto" @click="eliminarEstudio(estudio)" title="Eliminar"></i>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="comentarios-container">
                  <textarea placeholder="Comentarios" v-model="nuevaCita.comentarios"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer flex-column align-items-end pt-0">
          <p v-if="!camposLlenos" class="color-rojo">* Campos Obligatorios</p>
          <div class="d-flex">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary ms-2" :disabled="!camposLlenos" @click="agendarNuevaCita()"
              data-bs-dismiss="modal">Agendar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END MODAL CREAR -->


  <!-- MODAL EDITAR -->
  <div class="modal fade" id="detallesCita" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header ps-4">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Folio: {{ citaSeleccionada.compra.folio }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid pt-2">
            <div class="row">
              <div class="col-sm-6 col-lg-5">
                <div class="input-container">
                  <label for="nombre">Nombre<span class="color-rojo">*</span></label>
                  <input :class="{ 'borde-rojo': camposInvalidosEditar.nombre }"
                    @blur="validarCampoFormEditar('nombre')" type="text" id="nombre"
                    v-model="citaSeleccionada.paciente.nombre">
                  <p v-if="camposInteraccionEditar.nombre && !citaSeleccionada.paciente.nombre"
                    class="mb-0 fs-14 color-rojo">Campo requerido</p>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 mt-2 mt-sm-0">
                <div class="input-container">
                  <label for="apellidos">Apellidos<span class="color-rojo">*</span></label>
                  <input type="text" id="apellidos" v-model="citaSeleccionada.paciente.apellidos">
                </div>
              </div>
              <div class="col-sm-6 col-lg-3 mt-2 mt-lg-0">
                <div class="input-container">
                  <label for="fecha_nacimiento">Fecha Nacimiento<span class="color-rojo">*</span></label>
                  <input type="date" id="fecha_nacimiento" v-model="citaSeleccionada.paciente.fecha_nacimiento">
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 mt-2 ">
                <div class="input-container">
                  <label for="telefono">Telefono<span class="color-rojo">*</span></label>
                  <input type="number" id="telefono" v-model="citaSeleccionada.paciente.telefono">
                </div>
              </div>

              <div class="col-sm-6 col-lg-4 mt-2 ">
                <div class="input-container">
                  <label for="correo">Email</label>
                  <input type="text" id="correo" v-model="citaSeleccionada.paciente.correo" placeholder="Email">
                </div>
              </div>

              <div class="col-sm-6 col-lg-4 mt-2 ">
                <div class="input-container">
                  <label for="calle">Calle</label>
                  <input type="text" id="calle" v-model="citaSeleccionada.paciente.calle" placeholder="Calle">
                </div>
              </div>
              <div class="col-6 col-md-3 col-lg-2 mt-2 ">
                <div class="input-container">
                  <label for="no_ext">No. Ext</label>
                  <input type="number" id="no_ext" v-model="citaSeleccionada.paciente.num_ext" placeholder="No. Ext">
                </div>
              </div>
              <div class="col-6 col-md-3 col-lg-2 mt-2 ">
                <div class="input-container">
                  <label for="no_int">No. Int</label>
                  <input type="text" id="no_int" v-model="citaSeleccionada.paciente.num_int" placeholder="No. Int">
                </div>
              </div>
              <div class="col-8 col-md-6 col-lg-6 mt-2 ">
                <div class="input-container">
                  <label for="colonia">Colonia</label>
                  <input type="text" id="colonia" v-model="citaSeleccionada.paciente.colonia" placeholder="Colonia">
                </div>
              </div>
              <div class="col-4 col-md-3 col-lg-2 mt-2 ">
                <div class="input-container">
                  <label for="cp">C.P.</label>
                  <input type="numer" id="cp" v-model="citaSeleccionada.paciente.cp" placeholder="C.P.">
                </div>
              </div>
              <div class="col-sm-6 col-md-5 col-lg-4 mt-2 ">
                <div class="input-container">
                  <label for="colonia">Municipio</label>
                  <input type="text" id="colonia" v-model="citaSeleccionada.paciente.municipio" placeholder="Municipio">
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-4 mt-2 ">
                <div class="input-container">
                  <label for="estado">Estado</label>
                  <input type="text" id="estado" v-model="citaSeleccionada.paciente.estado" placeholder="Estado">
                </div>
              </div>
              <div class="col-sm-7 col-md-6 col-lg-4 mt-2 ">
                <div class="input-container">
                  <label for="pais">País</label>
                  <input type="text" id="pais" v-model="citaSeleccionada.paciente.pais" placeholder="País">
                </div>
              </div>
            </div>
            <hr>

            <div class="row">
              <div class="col-md-6">
                <h4 class="fs-5">Cita</h4>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-container">
                      <label for="dia">Día<span class="color-rojo">*</span></label>
                      <input v-model="citaSeleccionada.fecha" @change="obtenerHorariosDisponibles()" type="date"
                        id="dia" onclick="this.showPicker()" class="fechaMinima"> <!--Pendiente-->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-container">
                      <label for="hora">Hora<span class="color-rojo">*</span></label>
                      <div class="time-container">
                        <select class="" id="inputHora" v-model="citaSeleccionada.hora" @change="actualizarHora">
                          <option v-for="hora in opciones.horas" :key="hora" :value="hora">{{ hora }}</option>
                          <!--Pendiente-->
                        </select> :
                        <!-- Select MINUTOS -->
                        <select class="" id="inputMinutos" v-model="citaSeleccionada.minutos">
                          <option v-for="minuto in opciones.minutos[citaSeleccionada.hora]" :key="minuto"
                            :value="minuto">
                            {{
                              minuto }}
                          </option> <!--Pendiente-->
                        </select>
                        <i class="fa-regular fa-clock ms-auto color-verde fs-22"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="input-container mt-3">
                  <h4><span class="color-verde">Total:</span> <span class="fs-5">{{
                    formatearPrecio(sumaTotal) }}</span></h4>
                </div>
              </div>

              <div class="col-md-6">
                <h4 class="fs-5 mb-4">Estudios <span class="color-rojo">*</span></h4>
                <!-- Buscador -->
                <div class="search-container">
                  <i class="fa-solid fa-magnifying-glass" for="buscar"></i>
                  <input v-model="inputBusqueda" @input="resultadosBusqueda" @focus="mostrarResultados"
                    @blur="ocultarResultados" type="text" placeholder="Buscar.." id="buscar">

                  <!--  -->
                  <div v-if="inputBusqueda !== '' && resultadosVisibles" class="resultados-container">
                    <!-- Resultados -->
                    <div v-if="estudiosFiltrados.length > 0" v-for="(estudio, index) in estudiosFiltrados" :key="index"
                      class="resultados-individual-cotainer" @click="añadirEstudio(estudio)">
                      <img :src="estudio.img ? `./iconos_estudios/${estudio.img}` : `./iconos_estudios/general.png`">
                      <h2>{{ estudio.nombre }}</h2>
                      <p>${{ estudio.precio }}</p>
                    </div>
                    <div v-else>
                      <h2 class="text-center fs-20 color-gris mb-0">Sin resultados</h2>
                    </div>
                  </div>
                </div>
                <p v-if="this.estudiosSeleccionados.length === 0" class="ps-4 color-rojo">Seleccione un estudios</p>

                <!-- End Buscador -->
                <!-- Estudios Seleccionados -->
                <div v-for="(estudio, index) in estudiosSeleccionados" :key="index" class="estudio-container mt-2">
                  <p class="ps-2 mb-0">{{ estudio.nombre }} - ${{ estudio.precio }}</p>
                  <i class="fa-solid fa-minus ms-auto" @click="eliminarEstudio(estudio)" title="Eliminar"></i>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="comentarios-container">
                  <textarea placeholder="Comentarios" v-model="citaSeleccionada.comentarios"></textarea>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer flex-column align-items-end pt-0">
          <p v-if="!camposLlenosModalEditar" class="color-rojo">* Campos Obligatorios</p>
          <div class="d-flex">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary  ms-2" :disabled="!camposLlenosModalEditar"
              @click="guardarCambios()">Guardar Cambios</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END MODAL EDITAR -->

</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';
import Swal from 'sweetalert2';
import _ from 'lodash';
import * as XLSX from 'xlsx';
// import VCalendar from 'v-calendar'; // Importa el componente principal
// import 'v-calendar/dist/style.css'; // Asegúrate de importar el estilo

// import { useRouter } from 'vue-router';
// import { useStore } from 'vuex';

export default {
  components: {}, //VCalendar
  data() {
    return {
      estudios: [],
      estudiosFiltrados: [],
      inputBusqueda: '',
      resultadosVisibles: false,
      estudiosSeleccionados: [],
      isNavbarOpen: false,
      isSideBarOpen: true,
      citas: [],
      citasFiltradas: [],
      selectedDay: new Date(), // Valor inicial para la fecha seleccionada
      citaSeleccionada: {
        compra: { //Tuve que declarar esta propiedad para que no fallara el modal
        },
        paciente: {

        },
      },
      attrs: [
        {
          key: 'today',
          highlight: true,
          dates: new Date(),
        },
      ],
      opciones: {
        horas: '',
        minutos: '',
      },
      nuevaCita: {
        nombre: '',
        apellidos: '',
        fecha_nacimiento: '',
        correo: '',
        telefono: '',
        calle: '',
        no_ext: '',
        colonia: '',
        municipio: '',
        estado: '',
        pais: '',
        fecha: '',
        hora: '',
        minutos: '',
        comentarios: '',
      },
      camposInvalidos: {},
      camposInvalidosEditar: {},
      camposInteraccion: {},
      camposInteraccionEditar: {},
    };
  },
  async mounted() {
    await this.obtenerCitas();
    await this.obtenerEstudios();
    this.filtrarCitasPorFecha();

    const modalCrearCita = document.getElementById('crearCita');
    const modalDetallesCita = document.getElementById('detallesCita');

    //Para vaciar array de estudios seleccionados al cerrar el modal de CrearCita, tuve que ponerle un retraso ya que se ejecutaba dos veces
    const handleModalHide = _.debounce(() => {
      this.estudiosSeleccionados = [];
    }, 100);
    modalCrearCita.addEventListener('hide.bs.modal', handleModalHide);

    //Para vaciar array de estudis seleccionados al cerrar el modal de DetallesCita(editarCita)
    modalDetallesCita.addEventListener('hide.bs.modal', () => {
      this.estudiosSeleccionados = [];
    });

    this.fechaMinima();
  },
  computed: {
    sumaTotal() {
      return this.estudiosSeleccionados.reduce((total, estudio) => { //Reduce itera sobre un array y acumula un valor.
        const precio = parseFloat(estudio.precio) || 0; //Convertir la cadena de texto a numero
        return total + precio;
      }, 0);
    },
    camposLlenos() {
      return (
        this.nuevaCita.nombre !== '' &&
        this.nuevaCita.apellidos !== '' &&
        this.nuevaCita.fecha_nacimiento !== '' &&
        this.nuevaCita.telefono !== '' &&
        this.nuevaCita.fecha !== '' &&
        this.nuevaCita.hora !== '' &&
        this.nuevaCita.minutos !== '' &&
        this.estudiosSeleccionados.length > 0
      );
    },
    camposLlenosModalEditar() {
      return (
        this.citaSeleccionada.paciente.nombre !== '' &&
        this.citaSeleccionada.paciente.apellidos !== '' &&
        this.citaSeleccionada.paciente.telefono !== '' &&
        this.citaSeleccionada.fecha !== '' &&
        this.citaSeleccionada.hora !== '' &&
        this.citaSeleccionada.minutos !== '' &&
        this.estudiosSeleccionados.length > 0
      );
    },
  },
  methods: {
    descargarPrecios() {
      this.obtenerEstudios(); //Se actualiza lista de estudios antes de descargarlos

      const datosFiltrados = this.estudios.map(estudio => ({ //Se filtra el array estudios para solo para solo imprimir en el Excel las columnas deseadas
        codigo: estudio.codigo,
        nombre: estudio.nombre,
        precio: estudio.precio
      }))

      //Se genera el Excel
      const ws = XLSX.utils.json_to_sheet(datosFiltrados, { header: ["codigo", "nombre", "precio"] }); //Convierte al array estudios en una hoja de calculo
      const wb = XLSX.utils.book_new(); //Crea un nuevo libro de trabajo
      XLSX.utils.book_append_sheet(wb, ws, "Estudios"); //Añade la hoja al libro
      XLSX.writeFile(wb, "estudios_precios.xlsx"); //Genera y descarga el Excel
    },
    abrirModalNuevaCita() {
      const year = this.selectedDay.getFullYear();
      const month = String(this.selectedDay.getMonth() + 1).padStart(2, '0');
      const day = String(this.selectedDay.getDate()).padStart(2, '0');
      const fechaFormateada = `${year}-${month}-${day}`;

      this.nuevaCita.fecha = fechaFormateada;
      this.HorariosDisNuevacita();
      this.$nextTick(() => {
        const modal = new Modal(document.getElementById('crearCita'));
        modal.show();
      });

    },
    validarCampo(campo) {
      this.camposInteraccion[campo] = true;
      //Para validar modal NUEVA CITA
      if (!this.nuevaCita[campo]) {
        this.camposInvalidos[campo] = true;
      } else {
        this.camposInvalidos[campo] = false;
      }
    },
    validarCampoFormEditar(campo) {
      this.camposInteraccionEditar[campo] = true;
      //Para validar modal EDITAR CITA
      if (!this.citaSeleccionada.paciente[campo]) {
        this.camposInvalidosEditar[campo] = true;
      } else {
        this.camposInvalidosEditar[campo] = false;
      }
    },
    //Funcion para calendario, solo permite seleccionar un dia despues de hoy
    fechaMinima() {
      const inputs = document.querySelectorAll('.fechaMinima');

      const diaDeHoy = new Date();

      const año = diaDeHoy.getFullYear();
      const mes = String(diaDeHoy.getMonth() + 1).padStart(2, '0');
      const dia = String(diaDeHoy.getDate()).padStart(2, '0');

      const fechaMinima = `${año}-${mes}-${dia}`;

      inputs.forEach(input => {
        input.setAttribute('min', fechaMinima);
      })
    },
    async generarPDF(data) {
      console.log(data);
      try {
        Swal.fire({
          title: 'Cargando...',
          text: 'Por favor espere.',
          allowOutsideClick: false,
          showConfirmButton: false,
          willOpen: () => {
            Swal.showLoading();
          }
        });
        //Buscar estudios en this.estudios y enviarlos en la solicitud
        const estudios = data.compra.detalle_compra.map(detalle => { //map itera sobre cada elemento del array y devuelve un nuevo array con los resultados
          return this.estudios.find(e => e.id === detalle.estudio_id); //find busca en this.estudios en cada iteracion que hace map sobre detalle_compra 
        });

        if (estudios.length === data.compra.detalle_compra.length) {
          const response = await axios.post('/generarPDF', { data, estudios });
          const pdfBase64 = response.data.pdf;
          Swal.close(); // Cerrar la alerta de carga si hay un error

          // Crear una URL para el PDF y abrirlo en una nueva ventana
          const pdfBlob = new Blob([new Uint8Array(atob(pdfBase64).split("").map(char => char.charCodeAt(0)))], { type: 'application/pdf' });
          const url = window.URL.createObjectURL(pdfBlob);
          window.open(url, '_blank'); // Abre el PDF en una nueva ventana

        } else {
          console.log('No se encontron todos los estudios')
          Swal.fire('Error', 'No se encontrar los estudios necesarios.', 'error');
        }


      } catch (error) {
        Swal.close();
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un error al genera el PDF. Por favor, inténtalo más tarde.',
          confirmButtonText: 'Aceptar'
        });
        console.log('Error al agendar la cita', error.message);
      }
    },
    async agendarNuevaCita() {
      try {
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
        const response = await axios.post('/agendarNuevaCita', {
          infoCita: this.nuevaCita,
          estudios: this.estudiosSeleccionados
        });
        //Obtener el folio y el PDF de la respuesta
        const folio = response.data.folio;

        //Esto es para actualizar la informacion con la nueva cita creada
        await this.obtenerCitas();
        await this.filtrarCitasPorFecha();

        const htmlContent = this.nuevaCita.correo ?
          `Folio: <strong>${folio}</strong><br>Se ha notificado al paciente al correo: <strong> ${this.nuevaCita.correo} </strong>` : '';
        Swal.fire({
          icon: "success",
          title: "Cita Agendada",
          html: htmlContent,
          confirmButtonText: 'Aceptar',
          allowOutsideClick: false,
          showConfirmButton: true, // No mostrar botón
        });

        this.nuevaCita = {}; //Se vacia el formulario
        this.estudiosSeleccionados = []; //Se vacia el array de estudios seleccionados


      } catch (error) {
        Swal.close();

        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un error al agendar la cita. Por favor, inténtalo más tarde.',
          confirmButtonText: 'Aceptar'
        });

        console.log('Error al agendar la cita', error.message);
        console.log(this.nuevaCita.fecha_nacimiento);

      }
    },

    async eliminarCita(cita) {
      try {
        //Alerta Confirmacion
        const confirmation = await Swal.fire({
          title: '¿Estás seguro?',
          text: "Esta acción no se puedra deshacer.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        });

        //Eliminar de BD
        if (confirmation.isConfirmed) {
          await axios.delete('/eliminarCita', {
            data: { cita }
          });

          //Eliminar del Array local
          const index = this.citas.findIndex(e => e.id === cita.id);
          if (index !== 1) {
            this.citas.splice(index, 1);
          }

          this.filtrarCitasPorFecha();

          //Alerta Exito
          const result = await Swal.fire({
            icon: "success",
            title: "Cita Eliminada",
            confirmButtonText: 'Aceptar',
            allowOutsideClick: false,
            showConfirmButton: true, // No mostrar botón
          })
        }

      } catch (error) {
        Swal.close();

        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un error al eliminar la cita. Por favor, inténtalo más tarde.',
          confirmButtonText: 'Aceptar'
        });

        console.log('Error al eliminar la cita', error.message);
      }
    },
    async guardarCambios() {
      try {
        //Alerta Actualizando...
        Swal.fire({
          title: 'Actualizando Cita...',
          text: 'Por favor espere.',
          allowOutsideClick: false,
          showConfirmButton: false,
          willOpen: () => {
            Swal.showLoading();
          }
        });
        //Solicitud al BackEnd (envio del correo)
        const response = await axios.post('/actualizarCita', {
          infoCita: this.citaSeleccionada, //Necesito enviar los datos en un array anidado para que laravel los pueda recepcionar
          estudios: this.estudiosSeleccionados
        });

        await this.obtenerCitas();
        await this.filtrarCitasPorFecha();

        const htmlContent = this.citaSeleccionada.paciente.correo ?
          `Se ha notificado al paciente sobre la actualización de su cita al correo: <strong>${this.citaSeleccionada.paciente.correo}</strong>` : '';
        Swal.fire({
          icon: "success",
          title: "Cita Actualizada",
          html: htmlContent,
          confirmButtonText: 'Aceptar',
          allowOutsideClick: false,
          showConfirmButton: true, // No mostrar botón
        })

        this.$nextTick(() => {
          const modalElement = document.getElementById('detallesCita');
          if (modalElement) {
            const modalInstance = Modal.getInstance(modalElement); //Verifica si la instancia del modal ya existe
            if (modalInstance) { //Si la instancia del modal existe lo cierra
              modalInstance.hide(); // Cierra el modal si ya está instanciado
            } else {
              const modal = new Modal(modalElement); // Si no existe la instancia del modal la Inicializa
              modal.hide(); // Luego lo oculta
            }
          } else {
            console.error('Modal element not found');
          }
        });
        // sessionStorage.removeItem('infoCita'); //Se elimna la sessionStorage, no estoy seguro de que sea necesario.

      } catch (error) {
        Swal.close();

        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un error al actualizar la cita. Por favor, inténtalo más tarde.',
          confirmButtonText: 'Aceptar'
        });

        console.log('Error al guardar los cambios', error.message);
      }
    },
    actualizarHora() {
      if (this.citaSeleccionada.hora) {
        this.citaSeleccionada.minutos = this.opciones.minutos[this.citaSeleccionada.hora][0];
      }
    },
    mostrarInfoDetalle(data) {
      this.citaSeleccionada = JSON.parse(JSON.stringify(data));
      //Extraer fecha, hora y minutos de fecha_hora
      const fechaHora = new Date(this.citaSeleccionada.fecha_hora);
      this.citaSeleccionada.fecha = fechaHora.toISOString().split('T')[0];
      this.citaSeleccionada.hora = fechaHora.toTimeString().slice(0, 5).split(':')[0];
      this.citaSeleccionada.minutos = fechaHora.toTimeString().slice(0, 5).split(':')[1];

      //Filtro los estudios de la cita del array estudios basado en el estudio_id
      this.estudiosSeleccionados = this.citaSeleccionada.compra.detalle_compra.map(detalle => {
        return this.estudios.find(estudio => estudio.id === detalle.estudio_id);
      })
      this.obtenerHorariosDisponibles(); //Ejecuto la funcion que se encarga de obtener los horarios disponibles

      this.$nextTick(() => {
        const modal = new Modal(document.getElementById('detallesCita'));
        modal.show();
      });
    },
    actualizarHoraNuevaCita() {
      if (this.nuevaCita.hora) {
        this.nuevaCita.minutos = this.opciones.minutos[this.nuevaCita.hora][0];
      }
    },
    async HorariosDisNuevacita() {
      try {
        const fecha = new Date(this.nuevaCita.fecha); //Se obtiene solo la fecha
        const response = await axios.get('/disponibilidad-horario', {
          params: { fecha: fecha },
        });
        const horariosOcupados = response.data; //horariosOcupados es un objeto donde las claves son las hora y los valores son array de minutos ocupados para esa hora.
        // 07:['00']
        // 07:['15']
        // console.log(horariosOcupados);
        //Definir el rango de hora y munutos
        const rangoHoras = Array.from({ length: 11 }, (_, i) => String(i + 7).padStart(2, '0')); //Genera un array de horas desde las 07 hasta las 14 y las convierte a texto
        const rangoMinutos = ['00', '15', '30', '45'];

        //Calcular HORAS DISPONIBLRES
        const horasDisponibles = rangoHoras.filter(hora => { //filter crear un nuevo array con los elementos del array original que cumplen cierta condicion, hora es el valor actual de la iteracion de array "rangoHoras".
          return !horariosOcupados.hasOwnProperty(hora) ||  //hasOwnProperty verifica si el objeto(horariosOcupados) no tiene una propiedad con cierto nombre(en este caso: hora)
            horariosOcupados[hora].length < rangoMinutos.length; //Verifica si el numero de minutos ocupados es menor que el total de minutos disponibles
        });

        // Calcular MINUTOS DISPONIBLRES por cada hora
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
        this.nuevaCita.hora = this.opciones.horas.length ? this.opciones.horas[0] : '';
        this.nuevaCita.minutos = this.nuevaCita.hora ? this.opciones.minutos[this.nuevaCita.hora][0] : '';
        // console.log('Se ejecuto funcion obtenerHorariosDisoponibles')
      } catch (error) {
        console.error('Error al obtener los horarios disponibles: ', error);
      }
    },

    async obtenerHorariosDisponibles() {
      try {
        const fecha = new Date(this.citaSeleccionada.fecha); //Se obtiene solo la fecha
        const response = await axios.get('/disponibilidad-horario', {
          params: { fecha: fecha },
        });
        const horariosOcupados = response.data; //horariosOcupados es un objeto donde las claves son las hora y los valores son array de minutos ocupados para esa hora.
        // 07:['00']
        // 07:['15']
        // console.log(this.citaSeleccionada.fecha);

        //Definir el rango de hora y munutos
        const rangoHoras = Array.from({ length: 11 }, (_, i) => String(i + 7).padStart(2, '0')); //Genera un array de horas desde las 07 hasta las 17 y las convierte a texto
        const rangoMinutos = ['00', '15', '30', '45'];

        //CALCULAR HORAS DISPONIBLES
        const horasDisponibles = rangoHoras.filter(hora => { //filter crear un nuevo array con los elementos del array original que cumplen cierta condicion, hora es el valor actual de la iteracion de array "rangoHoras".
          return !horariosOcupados.hasOwnProperty(hora) ||  //hasOwnProperty verifica si el objeto(horariosOcupados) no tiene una propiedad con cierto nombre(en este caso: hora)
            horariosOcupados[hora].length < rangoMinutos.length; //Verifica si el numero de minutos ocupados es menor que el total de minutos disponibles
        });

        // CALCULAR MINUTOS DISPONIBLES POR CADA HORA
        const minutosDisponiblesPorHora = {};
        for (const hora of horasDisponibles) {
          if (horariosOcupados.hasOwnProperty(hora)) { //Si la hora iterada se encuentra en las horas ocupadas se calculan los minutos disponibles
            minutosDisponiblesPorHora[hora] = rangoMinutos.filter(minuto => !horariosOcupados[hora].includes(minuto)); //Se crea un array solo con los minutos que no estan en el array de la hora acutal en el array "horariosOcupados", "minuto" corresponde a cada minuto del array "rangoMinutos", "horariosOCupados[hora]" obtiene el array de minutos ocupados para la hora actual, "includes(minuto)" verifica si el minuto esta en el array de minutos ocupados de la hora actual.
          } else {
            minutosDisponiblesPorHora[hora] = [...rangoMinutos]; // Copiar el array
          }
        }

        const horaSeleccionada = this.citaSeleccionada.hora;
        const minutosSeleccionados = this.citaSeleccionada.minutos;

        if (horaSeleccionada) {
          // Se agrega la hora seleccionada si no esta en el array de horarios disponibles, esto sirve para cuando todo el rango de minutos estan ocupados para una determinada hora.
          if (!horasDisponibles.includes(horaSeleccionada)) {
            horasDisponibles.push(horaSeleccionada);
          }

          if (horariosOcupados.hasOwnProperty(horaSeleccionada)) { //Verifica si la hora seleccionada esta dentro de los horarios ocupados
            const minutosOcupado = horariosOcupados[horaSeleccionada] || [];

            // Si la hora seleccionada está ocupada completamente, agrega solo la hora y minuto seleccionados
            if (minutosOcupado.length === rangoMinutos.length && !minutosOcupado.includes(minutosSeleccionados)) {
              horasDisponibles.push(horaSeleccionada); //Agregar la hora al array si todos los minutos etan ocupados
              minutosDisponiblesPorHora[horaSeleccionada] = [minutosSeleccionados]; // Establece los minutos para esa hora como solo el minuto seleccionado.
            }
            else {
              if (!minutosDisponiblesPorHora[horaSeleccionada]) {
                minutosDisponiblesPorHora[horaSeleccionada] = [];
              }

              if (!minutosDisponiblesPorHora[horaSeleccionada].includes(minutosSeleccionados)) { //Verifica si el minuto seleccionado no esta en el array de minutos diponibles
                minutosDisponiblesPorHora[horaSeleccionada].push(minutosSeleccionados); //Sino se encuentra lo agrega
              }
            }
          }
        }
        //Para ordenar objeto minutosDisponiblesPorHora
        for (const hora in minutosDisponiblesPorHora) {
          if (minutosDisponiblesPorHora.hasOwnProperty(hora)) {
            minutosDisponiblesPorHora[hora].sort((a, b) => a - b); // Ordena los minutos numéricamente
          }
        }

        this.opciones.horas = horasDisponibles.sort(); //sort ordena los elementos del array
        this.opciones.minutos = minutosDisponiblesPorHora;

        this.citaSeleccionada.hora = horaSeleccionada || (this.opciones.horas.length ? this.opciones.horas[0] : '');
        this.citaSeleccionada.minutos = minutosSeleccionados || (this.citaSeleccionada.hora ? this.opciones.minutos[this.citaSeleccionada.hora][0] : '');

        // console.log('Se ejecuto funcion obtenerHorariosDisoponibles')
      } catch (error) {
        console.error('Error al obtener los horarios disponibles: ', error);
      }
    },
    eliminarEstudio(estudio) {
      const index = this.estudiosSeleccionados.findIndex(e => e.codigo === estudio.codigo);
      if (index !== -1) {
        this.estudiosSeleccionados.splice(index, 1);
        // console.log(this.estudiosSeleccionados);
      } else {
        console.log('no se encontro el estudio en los estudios Seleccionados')
      }
    },
    añadirEstudio(estudio) {
      const index = this.estudiosSeleccionados.findIndex(e => e.codigo === estudio.codigo);
      if (index === -1) {
        this.estudiosSeleccionados.push(estudio);
        // console.log(this.estudiosSeleccionados);
      }
    },
    async ocultarResultados() {
      await new Promise(resolve => setTimeout(resolve, 200));
      // Una vez que el retraso se complete, oculta los resultados
      this.resultadosVisibles = false;
      // Restablece el inputBusqueda después de que el retraso haya terminado
      this.inputBusqueda = '';
    },
    mostrarResultados() {
      this.resultadosVisibles = true;
    },
    resultadosBusqueda() {
      const parametroBusqueda = this.inputBusqueda.toLocaleLowerCase();

      this.estudiosFiltrados = this.estudios.filter(estudio =>
        estudio.codigo.toLocaleLowerCase().includes(parametroBusqueda) ||
        estudio.nombre.toLocaleLowerCase().includes(parametroBusqueda) ||
        estudio.sinonimo.toLocaleLowerCase().includes(parametroBusqueda)
      );
    },

    async obtenerCitas() {
      try {
        const response = await this.$axios.get('/obtenerCitas');
        this.citas = response.data;

        //Obtener las fechas
        const citasFechas = this.citas.map(cita => {
          return new Date(cita.fecha_hora).toISOString().split('T'[0]); //Se obtiene solo la fecha
        });

        //Configurar los atributos del calendario para los dias con cita
        this.attrs = citasFechas.map(fecha => ({
          key: `cita-${fecha}`,
          highlight: true,
          dates: new Date(fecha),
        }));

        // console.log(this.citas);
      } catch (error) {
        console.error('Error obteniendo las citas:', error);
      }
    },
    async obtenerEstudios() {
      try {
        const response = await this.$axios.get('/obtenerEstudiosTodos');
        this.estudios = response.data;
        // console.log(this.estudios);
      } catch (error) {
        console.error('Error obteniendo los estudios:', error);
      }
    },
    filtrarCitasPorFecha() {
      //Ocultar el SideBar dependiendo de la anchura de la pantalla
      if (window.innerWidth < 1024) {
        this.toggleSidebar();
      }

      if (this.selectedDay) {
        const fechaSeleccionada = this.selectedDay.toISOString().split('T')[0]; //Obtener solo la fecha
        // console.log(this.citas);
        //Filtrar citas por fecha seleccionada
        this.citasFiltradas = this.citas.filter(cita => {
          const citaFecha = new Date(cita.fecha_hora).toISOString().split('T')[0]; //Obtener solo la fecha
          // console.log(this.citasFiltradas);
          return citaFecha === fechaSeleccionada;
        });

        //Ordenar las citas filtardas por hora
        this.citasFiltradas.sort((a, b) => {
          const horaA = new Date(a.fecha_hora).getTime();
          const horaB = new Date(b.fecha_hora).getTime();
          return horaA - horaB;
        });
      }
    },
    async logout() {
      try {
        await axios.post('/logout');
        this.$store.commit('setAuth', false);
        this.$router.push('/login');
      } catch (error) {
        console.error('Error al cerrar sesión', error);
      }
    },
    formatearPrecio(precio) {
      const numero = parseFloat(precio); //Se convierte el precio a decimal
      return numero.toLocaleString('es-MX', { //Se formatea a moneda mexicana
        style: 'currency',
        currency: 'MXN',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },
    formatearFecha(fecha) {
      if (!(fecha instanceof Date)) {
        fecha = new Date(fecha);
      }
      return fecha.toLocaleDateString('es-MX', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
      });
    },
    formatearHora(fechaHora) {
      const date = new Date(fechaHora);
      const horas = date.getHours().toString().padStart(2, '0');
      const minutos = date.getMinutes().toString().padStart(2, '0');
      return `${horas}:${minutos}`;
    },
    // async diaSeleccionado({ startDate }) { //Cambiar esta funcion
    //   try {
    //     const diaSeleccionado = startDate.toISOString().split('T')[0]; // Formatear la fecha
    //     const response = await axios.get('/obtenerCitas');
    //     this.citas = response.data;
    //   } catch (error) {
    //     console.error('Error al obtener las citas:', error)
    //   }
    // },
    //Metodos NAVBAR
    toggleNavbar() {
      this.isNavbarOpen = !this.isNavbarOpen;
    },
    ocultarNavbar() {
      setTimeout(() => {
        this.isNavbarOpen = false;
      }, 100)
    },
    //METODOS SIDEBAR
    toggleSidebar() {
      this.isSideBarOpen = !this.isSideBarOpen;
    },
  }
};
</script>

<style scoped>
.navbar-brand img {
  height: 90px;
}

.link-navbar {
  font-weight: bold;
  transition: all 0.2s ease;
  cursor: pointer;
}

.link-navbar a {
  text-decoration: none;
  color: #8e9093;
}

.link-navbar:hover,
.link-navbar:hover a {
  color: #00a95e;
}

.sidebar-container {
  /* border: 1px solid red; */
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
  width: 270px;
  height: 100%;
  position: fixed;
  top: 0;
  right: 100%;
  overflow-x: hidden;
  transition: 0.3s;
  padding-top: 90px;
  background: rgb(245, 245, 245);
  z-index: 10;
}

.sidebar-open {
  transform: translateX(270px);
}

.main-container {
  padding: 110px 30px 30px 60px;
}

.padding-izquierdo {
  padding-left: 300px;
}

@media(max-width:768px) {
  .padding-izquierdo {
    padding-left: 0px;
  }
}

.barra-verde {
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
  width: 30px;
  height: 100%;
  position: fixed;
  right: 100%;
  top: 0;
  overflow-x: hidden;
  transition: 0.3s;
  padding-top: 90px;
  background: var(--color-verde);
}

.barra-verde button {
  background: none;
  border: none;
  color: white;
  font-size: 25px;
}

.barra-visible {
  transform: translateX(30px);
}

.menu-lateral-container {
  display: flex;
  flex-direction: column;
}

.calendar-container {
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-eye2,
.btn-trash {
  border-radius: 5px;
  width: 35px;
}

.fecha-verde {
  display: inline-block;
  background: var(--color-verde);
  border-radius: 10px;
  color: white;
  padding: 5px 20px;
}

.fecha-roja {
  display: inline-block;
  background: rgb(230, 0, 0);
  border-radius: 10px;
  color: white;
  padding: 5px 20px;
}

.contenedor-amarillo h3 {
  display: inline;
  background: rgb(255, 255, 129);
  padding: 5px 20px;
  border-radius: 10px;
  margin: auto;
}

.calendar-icon-container {
  display: flex;
  justify-content: center;
}

.calendar-icon-container i {
  font-size: 15rem;
  color: var(--color-gris);
  margin-top: 3rem;
}

.input-container {
  display: flex;
  flex-direction: column;
}

.input-container input {
  border: 2px solid var(--color-verde);
  border-radius: 5px;
}

.borde-rojo {
  border: 2px solid var(--color-rojo) !important;
}

.estudio-container {
  border: 2px solid var(--color-verde);
  border-radius: 5px;
  display: flex;
  align-items: center;
}

.estudio-container i {
  color: var(--color-verde);
  margin-right: 5px;
  font-size: 1.5rem;
}

.search-container {
  display: flex;
  align-items: center;
  border: 2px solid var(--color-verde);
  border-radius: 5px;
  position: relative;
}

.search-container input {
  width: 100%;
  border: none;
}

.search-container input:focus {
  outline: none;
}

.search-container i {
  /* position: absolute;
top: 5px;
left: 10px; */
  font-size: 20px;
  padding-left: 5px;
  color: var(--color-gris);
}

.modal-content {
  height: auto;
  max-height: auto;
}


.resultados-container {
  background: white;
  width: 100%;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  padding: 5px;
  position: absolute;
  top: 110%;
}

.resultados-individual-cotainer {
  display: flex;
  align-items: center;
  margin-bottom: 5px;
  transition: all 0.3s ease;
}

.resultados-individual-cotainer:hover {
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

.resultados-individual-cotainer img {
  width: 13%;
}

.resultados-individual-cotainer h2 {
  font-size: 20px;
  margin-bottom: 0px;
  margin-left: 5px;
}

.resultados-individual-cotainer p {
  margin-bottom: 0px;
  margin-left: auto;
}

.time-container {
  border: 2px solid var(--color-verde);
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.time-container select {
  width: 50%;
  border: none;
}

.btn-success {
  background: var(--color-verde);
  border: var(--color-verde);
}

.btn-success:hover {
  background: #009652;
  border: #009652;
}

.comentarios-container textarea {
  width: 100%;
  height: 80px;
  border-radius: 5px;
  border: 2px solid #00a95e;
  resize: none;
}
</style>
