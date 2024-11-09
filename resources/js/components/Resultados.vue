<template>
  <div class="container-fluid">
    <div class="banner-resultados row">
      <div class="col-4 col-lg-5 d-flex align-items-center" style="position: relative;">
        <h3 class="ms-auto pe-xlg-5 ms-5" data-aos="fade-right">Resultados Clínicos</h3>
      </div>
      <div class="col-8 col-lg-7 d-flex pt-4 pt-lg-5" style="height: 100%;">
        <img :src="`./resultadosimg/banner.png`" class="mt-auto" data-aos="fade-left">
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2 class="text-center color-verde mt-5">Consulta tus resultados</h2>
        <div class="iframe-container">
          <iframe src="https://cdmi.tulab.mx/Cuenta/Login?noheader=1" width="100%" height="370" frameborder="0"
            style="border:0;">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Resultados',
  data() {
    return {
    }
  },
};
</script>

<style scoped>
h2 {
  font-size: 2rem !important;
  color: #00a95e !important;
}

.iframe-container {
  margin: 30px auto 80px;
  position: relative;
  height: 400px;
  /* Ajusta según sea necesario */
  overflow: hidden;
  /* Ejemplo de borde para el contenedor */
  border-radius: 10px;
  /* Bordes redondeados del contenedor */
}

@media (max-width:1024px) {
  .iframe-container {
    width: 70%;
  }
}

@media (max-width:768px) {
  .iframe-container {
    width: 100%;
  }
}

.iframe-container iframe {
  position: absolute;
  border: none;
  /* Color de fondo aplicado al iframe */
}

.banner-resultados {
  background-image: url('../../assets/imagenes/fondo_gris.png');
  background-size: cover;
  background-position: center;
  overflow: hidden;
  height: 250px;
  box-shadow: 0 0px 10px rgb(0, 0, 0, 0.3);
}

.banner-resultados img {
  height: 100%;
  /* width: 100%; */
  object-fit: cover;
}

.banner-resultados h3 {
  font-size: 1.3rem;
  text-align: center;
  color: var(--color-verde);
  font-weight: bold;
  position: absolute;
  right: -70%;
  top: 30%;
}

@media(min-width: 576px) and (max-width: 1024px) {
  .banner-resultados {
    height: 400px;
  }

  .banner-resultados h3 {
    font-size: 2.5rem;
  }
}
@media(min-width: 992px){
  .banner-resultados h3{
    right: -20%;
  }
}

@media(min-width: 1025px) {
  .banner-resultados {
    height: 550px;
  }

  .banner-resultados h3 {
    font-size: 3rem;
  }
  .banner-resultados img{
    height: 100%;
  }
}
</style>