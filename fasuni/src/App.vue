<template>
  <div class="container-fluid p-0 m-0">
    <Header></Header>
    <router-view></router-view>
  </div>
</template>

<script>
import '@/assets/styles/style.scss';
import Header from '@/components/Header';

export default {
  name: 'App',
  components: {
    Header
  }
};
</script>

<style lang="scss">
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
