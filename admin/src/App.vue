<template>
  <div id="app">
    <layout-broker :layouts="$options.layouts" :current="$route.meta.layout"></layout-broker>
  </div>
</template>

<script>
import '@/assets/styles/style.scss';
import LayoutBroker from '@/components/common/LayoutBroker';
import MainLayout from '@/components/common/MainLayout';

const layouts = {
  MainLayout
};

export default {
  name: 'App',
  components: {
    LayoutBroker
  },
  layouts
};
</script>

<style>
#app {
  font-family: Helvetica, Roboto, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
