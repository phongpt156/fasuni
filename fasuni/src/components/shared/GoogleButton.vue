<template>
  <a class="d-inline-block mr-3" ref="google">
    <font-awesome-icon :icon="icons.google"></font-awesome-icon>
  </a>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import googleIcon from '@fortawesome/fontawesome-free-brands/faGooglePlus';
import googleService from '@/shared/services/google.service';
import { mapMutations } from 'vuex';
import { reloadApp } from '@/shared/functions';

export default {
  components: {
    FontAwesomeIcon
  },
  data() {
    return {
      icons: {
        google: googleIcon
      }
    };
  },
  computed: {
    auth2() {
      return window.auth2;
    }
  },
  methods: {
    ...mapMutations('auth', [
      'setToken'
    ]),
    attachSignin(element) {
      this.auth2.attachClickHandler(element, {}, googleUser => {
        const idToken = googleUser.getAuthResponse().id_token;
        googleService.login({id_token: idToken})
          .then(response => {
            if (response.data && response.status === 200) {
              this.setToken(response.data.api_token);
              reloadApp();
            } else if (response.data.error) {
              alert(response.data.error);
            }
          });
      }, error => {
        console.log(JSON.stringify(error, undefined, 2));
      });
    }
  },
  mounted() {
    this.attachSignin(this.$refs.google);
  }
};
</script>

<style>

</style>
