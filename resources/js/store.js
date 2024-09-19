import { createStore } from 'vuex'; // Importa createStore desde vuex
import axios from 'axios';

export default createStore({
  state() {
    return {
      isAuthenticated: localStorage.getItem('isAuthenticated') === 'true', // Cambia esto según el estado de autenticación del usuario
      estudiosSeleccionados: [],
      estudiosSelecEmpresas: [],
      estudiosSelecIndustrial: [],
      activeRouteFooter: 'pacientes', //Variable para cambiar estilos de NavBar y Footer
    };
  },
  getters: {
    activeRouteFooter: state => state.activeRouteFooter,
    isAuthenticated: state => state.isAuthenticated,
    //Obtener estudios para Pacientes/Empresas
    getEstudiosSeleccionados: state => state.estudiosSeleccionados,
    getEstudiosSelecEmpresas: state => state.estudiosSelecEmpresas,
    getEstudiosSelecIndustrial: state => state.estudiosSelecIndustrial,
  },
  mutations: {
    changeActiveRoute(state, ruta){
      state.activeRouteFooter = ruta;
    },
    //Para menejar autenticacion con Vue
    setAuth(state, estatus) {
      state.isAuthenticated = estatus;
      localStorage.setItem('isAuthenticated', estatus)

    },
    //SECCION PACIENTE
    //Si el estudio ya existe lo elimina sino existe lo agrega
    añadirEstudio(state, estudio) {
      const index = state.estudiosSeleccionados.findIndex(e => e.id === estudio.id);
      if (index === -1) {
        state.estudiosSeleccionados.push(estudio);
      } else {
        state.estudiosSeleccionados.splice(index, 1);
      }
    },
    //Si el estudio no existe lo agrega
    añadirEstudio2(state, estudio) {
      const index = state.estudiosSeleccionados.findIndex(e => e.id === estudio.id);
      if (index === -1) {
        state.estudiosSeleccionados.push(estudio);
      }
    },
    eliminarEstudio(state, estudio) {
      const index = state.estudiosSeleccionados.findIndex(e => e.id === estudio.id);
      if (index !== -1) {
        state.estudiosSeleccionados.splice(index, 1);
      }
    },
    //END SECCION PACIENTE

    //SECCION EMPRESA
    //Si el estudio ya existe lo elimina sino existe lo agrega
    añadirEstudioEmpresas(state, estudio) {
      const index = state.estudiosSelecEmpresas.findIndex(e => e.id === estudio.id);
      if (index === -1) {
        state.estudiosSelecEmpresas.push(estudio);
      } else {
        state.estudiosSelecEmpresas.splice(index, 1);
      }
    },
    //Si el estudio no existe lo agrega
    añadirEstudioEmpresas2(state, estudio) {
      const index = state.estudiosSelecEmpresas.findIndex(e => e.id === estudio.id);
      if (index === -1) {
        state.estudiosSelecEmpresas.push(estudio);
      }
    },
    eliminarEstudioEmpresas(state, estudio) {
      const index = state.estudiosSelecEmpresas.findIndex(e => e.id === estudio.id);
      if (index !== -1) {
        state.estudiosSelecEmpresas.splice(index, 1);
      }
    },
    //END SECCION EMPRESA

    //SECCION INDUSTRIAL
    //Agregar/Eliminar estudio desde catalogo de estudios Industrial
    añadirEstudioIndustrial(state, estudio) {
      const index = state.estudiosSelecIndustrial.findIndex(e => e.id === estudio.id);
      if (index === -1) {
        state.estudiosSelecIndustrial.push(estudio);
      } else {
        state.estudiosSelecIndustrial.splice(index, 1);
      }
    },
    //Agregar estudio sino esta agregado desde boton solicitar Informacion
    añadirEstudioIndustrial2(state, estudio) {
      const index = state.estudiosSelecIndustrial.findIndex(e => e.id === estudio.id);
      if (index === -1) {
        state.estudiosSelecIndustrial.push(estudio);
      }
    },
    eliminarEstudioIndustrial(state, estudio) {
      const index = state.estudiosSelecIndustrial.findIndex(e => e.id === estudio.id);
      if (index !== -1) {
        state.estudiosSelecIndustrial.splice(index, 1);
      }
    },
    //END SECCION INDUSTRIAL
  },
  actions: {
    //Este metodo lo usar el routes.js para verificar si un usuario esta autenticado antes de acceder a una ruta
    // async checkAuth({ commit }) {
    //   try{
    //     await axios.get('/login')
    //     commit('setAuth', true);
    //     return true;
    //   }catch{
    //     commit('setAuth', false);
    //     return false;
    //   }
    // },
    // logout({ commit }) {
    //   localStorage.removeItem('authToken'); // Elimina el token
    //   commit('setAuth', false);
    // },
  },
});