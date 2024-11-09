import { createApp } from 'vue';
import App from './App.vue'; //Importo el componente raiz o principal que es donde se rendizaran mis distintos componentes
import router from './router/routes.js';
import store from './store';
//PrimeVue
import PrimeVue from "primevue/config";
import 'primevue/resources/themes/saga-blue/theme.css'; // Tema de PrimeVue (ajustar si cambias de tema)
import 'primevue/resources/primevue.min.css'; // CSS base de PrimeVue
import 'primeicons/primeicons.css'; // Íconos de PrimeVue
import axios from 'axios';
//Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
//Componentes PrimeVue
import Paginator from 'primevue/paginator';
//Animaciones
import AOS from 'aos';
import 'aos/dist/aos.css';
//Vue Calendar
import VCalendar from 'v-calendar';
import 'v-calendar/dist/style.css'; // Importa el estilo globalmente
//Prime Vue
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';
import Button from 'primevue/button';


// Obtener el token CSRF desde la metaetiqueta
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
// Configurar axios para que incluya el token CSRF en los encabezados de cada solicitud
axios.defaults.headers.common['X-CSRF-TOKEN'] = token;


//Animacion CSS

const app = createApp(App); //Creo mi aplicacion Vue basado en mi componente Principal
app.config.globalProperties.$axios = axios;
//Para animaciones
app.config.globalProperties.$AOS = AOS.init({
    duration: 1000, // Duración de la animación
    offset: 300,    // Desplazamiento desde el punto de disparo
  });

// REGISTRO DE COMPONENTES
app.component('Paginator', Paginator);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('ColumnGroup', ColumnGroup);
app.component('Row', Row);
app.component('Button', Button);

// PLUGINS
app.use(VCalendar); //Vue Calendar
app.use(router);
app.use(store);
app.use(PrimeVue);

//SE MONTA LA APLICACION
app.mount('#app');