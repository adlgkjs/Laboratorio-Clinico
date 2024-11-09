<template>
  <div class="container-fluid">
    <div class="row banner-nosotros">
      <div class="col-7 col-lg-6 d-flex align-items-center justify-content-end ">
        <h3 class="ml-auto" data-aos="fade-right">Acerca de nosotros</h3>
      </div>
      <div class="col-5 col-lg-6" style="height: 100%;">
        <img class="ms-lg-5 mt-3" :src="`./nosotros/banner.png`" alt="banner" data-aos="fade-left">
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row py-5 my-3">
      <div class="col-lg-10 mx-auto" data-aos="fade-up">
        <h2 class="text-center color-verde mb-4">CDMI - centro de Diagnóstico microbiológico e Inmunomolecular</h2>
        <p class="text-justify color-gris">Fue fundado en el año 2016 con el objetivo de posicionarse como un centro de
          diagnóstico clínico especializado, utilizando la más avanzada tecnología y un equipo altamente calificado.</p>
        <p class="text-justify color-gris">Con el propósito de contribuir con el diagnóstico oportuno, <span
            class="fw-bold color-verde">CDMI</span> colabora con diversas instituciones, pacientes, médicos y clientes
          del sector tanto público como privado, ofreciendo una amplia gama de servicios de genética molecular,
          inmunología, hematología, química clínica y microbiología. Además, se cuenta con un sistema de gestión de
          calidad que engloba todos los procesos con el objetivo de asegurar el cumplimiento adecuado de nuestros
          procedimientos y ofrecer el más alto nivel de servicio para garantizar la confiabilidad de los resultados.</p>
      </div>
    </div>
  </div>

  <div style="background: #e8e9ee;">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="img-calidad-container" data-aos="fade-up">
            <img :src="`./nosotros/politica_calidad.png`">
          </div>
        </div>
        <div class="col-lg-7 d-flex">
          <div class="my-auto" data-aos="fade-up">
            <h3 class="color-verde fs-2 fw-600">Política de Calidad</h3>
            <p class="color-gris text-justify"><span class="color-verde fw-600">En Centro de Diagnóstico Microbiológico
                e Inmunomolecular (CDMI),</span> estamos comprometidos en brindar servicios de referencia de alto valor
              diagnóstico, a través de las buenas prácticas profesionales; cumpliendo con los objetivos de calidad
              aplicables, el apego estricto de la <span class="color-verde fw-600">NMX-EC-15189-IMNC-2015 “Laboratorios
                Clínicos-Requisitos de la Calidad y Competencia”</span> y las expectativas de los clientes; lo anterior,
              con el propósito de mantener y mejorar nuestro Sistema Integral de Gestión de la Calidad a través de
              resultados confiables y oportunos.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row py-80 color-gris text-justify">
      <div class="col-lg-4">
        <div class="px-5" data-aos="fade-right">
          <h4 class="color-verde fw-600 mb-4">Misión</h4>
          <p>Garantizar los mejores servicios de laboratorio especializados y de alto valor diagnóstico, ofreciendo
            calidad y confianza a nuestros usuarios, conjugando el mejor equipo humano y la más avanzada tecnología del
            mercado.</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="px-5" data-aos="fade-up">
          <h4 class="color-verde fw-600 mb-4">Visión</h4>
          <p>Ser el laboratorio de referencia especializado, líder en México y América Latina, ofreciendo un servicio
            confiable, efectivo y dinámico, que supere las expectativas del usuario a través de nuestro compromiso con
            la innovación tecnológica y un equipo humano altamente capacitado.</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="px-5" data-aos="fade-down">
          <h4 class="color-verde fw-600 mb-4">Valores</h4>
          <p class="mb-1">
            <i class="fa-solid fa-angles-right"></i>
            Compañerismo
          </p>
          <p class="mb-1">
            <i class="fa-solid fa-angles-right"></i>
            Respeto
          </p>
          <p class="mb-1">
            <i class="fa-solid fa-angles-right"></i>
            Responsabilidad
          </p>
          <p class="mb-1">
            <i class="fa-solid fa-angles-right"></i>
            Calidad Humana
          </p>
          <p class="mb-1">
            <i class="fa-solid fa-angles-right"></i>
            Honestidad
          </p>
          <p class="mb-1">
            <i class="fa-solid fa-angles-right"></i>
            Puntualidad
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="img-footer-container">
    <img :src="`./nosotros/banner_footer.png`" alt="">
  </div>
</template>

<script>
import AOS from 'aos';
import 'aos/dist/aos.css';

export default {
  name: 'Nosotros',
};
</script>

<style scoped>
.img-footer-container {
  overflow: hidden;
}

.img-footer-container img {
  object-fit: cover;
  width: 100%;
  height: 100%;
}

.img-calidad-container {
  overflow: hidden;
  height: 400px;
  display: flex;
}

.img-calidad-container img {
  width: 65%;
  margin: auto;
}

.banner-nosotros {
  background-image: url('../../assets/imagenes/fondo_gris.png');
  background-size: cover;
  background-position: center;
  overflow: hidden;
  height: 250px;
  box-shadow: 0 0px 10px rgb(0, 0, 0, 0.3);
}

.banner-nosotros img {
  height: 100%;
  width: auto;
  object-fit: cover;
}

.banner-nosotros h3 {
  font-size: 1.3rem;
  text-align: center;
  color: var(--color-verde);
  font-weight: bold;
  

}

 @media(min-width: 576px) and (max-width: 1024px) {
  .banner-nosotros {
    height: 400px;
  }

  .banner-nosotros h3 {
    font-size: 2.5rem;
  }
}

@media(min-width: 1025px) {
  .banner-nosotros {
    height: 550px;
  }

  .banner-nosotros h3 {
    font-size: 3rem;
  }
} 


</style>