import { createRouter, createWebHistory } from 'vue-router';
import { useStore } from 'vuex';
//Importar Layouts
import SiteLayout from '../layouts/SitioLayout.vue';
import LogInLayout from '../layouts/LogInLayout.vue';
import AdminLayout from '../layouts/AdminLayout.vue';

//Importar componentes
import Inicio from '../components/Inicio.vue';
import Nosotros from '../components/Nosotros.vue';
import EstudiosPacientes from '../components/estudios/EstudiosPacientes.vue';
import EstudiosEmpresas from '../components/estudios/EstudiosEmpresas.vue';
import EstudiosIndustrial from '../components/estudios/EstudiosIndustrial.vue';
import Resultados from '../components/Resultados.vue';
import Contacto from '../components/Contacto.vue';
import AgendarCita from '../components/AgendarCita.vue';
import AvisoPrivacidad from '../components/AvisoPrivacidad.vue';
import TerminosyCondiciones from '../components/TerminosYCondiciones.vue';
import PoliticaSercicio from '../components/PoliticaServicio.vue';
import Login from '../components/login/Login.vue';
import AdminCitas from '../components/administracion/AdminCitas.vue';
import axios from 'axios';
import store from '../store';


//SE DECLARAN LAS RUTAS
const routes = [
  { //Rutas con SiteLayout
    path: '/',
    component: SiteLayout,
    children: [
      { path: '', name: 'Inicio', component: Inicio },
      { path: 'sobrenosotros', name: 'Nosotros', component: Nosotros },
      { path: 'pacientes', name: 'EstudiosPacientes', component: EstudiosPacientes },
      { path: 'empresas', name: 'EstudiosEmpresas', component: EstudiosEmpresas },
      { path: 'industrial', name: 'EstudiosIndustrial', component: EstudiosIndustrial },
      { path: 'resultados', name: 'Resultados', component: Resultados },
      { path: 'contacto', name: 'Contacto', component: Contacto },
      { path: 'citas', name: 'AgendarCita', component: AgendarCita },
      { path: 'avisoPrivacidad', name: 'AvisoPrivacidad', component: AvisoPrivacidad },
      { path: 'terminosYCondiciones', name: 'TerminosYCondiciones', component: TerminosyCondiciones },
      { path: 'politicaServicio', name: 'PoliticaServicio', component: PoliticaSercicio },
    ]
  },
  { //Rutas con LogInLayout
    path: '/login',
    component: LogInLayout,
    children: [
      { path: '', name: 'Login', component: Login }
    ]
  },
  { //Rutas con AdminLayout
    path: '/panelAdministracion',
    component: AdminLayout,
    children: [
      { path: '', name: 'AdminCitas', component: AdminCitas, }
    ],
    meta: { requiresAuth: true },
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/',
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return { el: to.hash };
    } else {
      //Esto es para forzar el inicio de cada pagina en la parte superior
      return { top: 0 };
    }
  }
});

//Guard de ruta global para verificar autenticacion
router.beforeEach(async (to, from, next) => {
  // const store = useStore();
  // const isAuthenticated = await store.dispatch('checkAuth'); //Se verifica si el usuario esta autenticado

  if (to.matched.some(record => record.meta.requiresAuth)) { //Si la ruta requiere autenticacion el usuario no esta autenticado
    try {
      const response = await axios.get('/check-auth');
      if (response.data.authenticated) {
        next();
      } else {
        next('/login');
      }
    } catch (error) {
      console.error('Error al verificar autenticación:', error);    
      next('/login') //Se redirige al login
    }
  } else {
    next();
  }
});

export default router;