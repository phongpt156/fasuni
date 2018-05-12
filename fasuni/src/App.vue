<template>
  <div class="container-fluid px-0 pb-0 m-0 app">
    <Header></Header>
    <div class="body">
      <router-view></router-view>
    </div>
    <Footer></Footer>
    <vue-progress-bar></vue-progress-bar>
  </div>
</template>

<script>
import '@/assets/styles/style.scss';
import Header from '@/components/shared/header/Header';
import Footer from '@/components/shared/footer/Footer';
import userService from '@/shared/services/user.service';
import { mapMutations } from 'vuex';

export default {
  name: 'App',
  created() {
    this.$Progress.start();
    this.$router.beforeEach((to, from, next) => {
      this.$Progress.start();
      next();
    });

    this.$router.afterEach((to, from) => {
      this.$Progress.finish();
    });
  },
  components: {
    Header,
    Footer
  },
  methods: {
    ...mapMutations(['setUser']),
    ...mapMutations('auth', [
      'removeToken'
    ]),
    authUser() {
      userService.index()
        .then(response => {
          if (response && response.data && response.status === 200) {
            this.setUser(response.data);
          } else {
            this.setUser(null);
            this.removeToken();
          }
        });
    }
  },
  mounted() {
    this.$Progress.finish();
    this.authUser();
  }
};
</script>

<style lang="scss">
  .app {
    padding-top: 3.125rem;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;

    .body {
      background-color: #f8f7f7;
    }
  }
</style>
