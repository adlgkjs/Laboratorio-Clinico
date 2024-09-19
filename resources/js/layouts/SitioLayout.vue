<template>
  <div>
    <CDMINavBar />
    <div class="general-container">
      <router-view />
    </div>
    <CDMIFooter />
  </div>
</template>

<script>
import CDMINavBar from '../components/partials/CDMINavBar.vue';
import CDMIFooter from '../components/partials/CDMIFooter.vue';

export default {
  name: 'App',
  components: {
    CDMINavBar,
    CDMIFooter
  }
};
</script>

<style scoped>
.general-container {
  padding-top: 152px;
}
</style>