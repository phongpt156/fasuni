<template>
  <a class="d-inline-block facebook-button" @click="login">
    <img :src="`${imageUrl}/facebook-icon.svg`" alt="" />
  </a>
</template>

<script>
import FACEBOOK_SERVICE from '@/shared/services/facebook.service';
import { GENDER, IMAGE_URL } from '@/shared/constants';
import { mapMutations } from 'vuex';
import { reloadApp } from '@/shared/functions';

export default {
  computed: {
    fb() {
      return window.FB;
    },
    imageUrl() {
      return IMAGE_URL;
    }
  },
  methods: {
    ...mapMutations('auth', [
      'setToken'
    ]),
    login() {
      this.fb.login(response => {
        const authResponse = response.authResponse;
        if (authResponse) {
          this.fb.api('/me?fields=id,name,email,gender,first_name,last_name,cover{source},picture{url},location', response => {
            response.access_token = authResponse.accessToken;
            const data = this.formatDataBodySendToServer(response);
            FACEBOOK_SERVICE.login(data)
              .then(response => {
                if (response.data && response.status === 200) {
                  this.setToken(response.data.api_token);
                  reloadApp();
                } else if (response.data.error) {
                  alert(response.data.error);
                }
              });
          });
        }
      });
    },
    formatDataBodySendToServer(data) {
      let location = '';
      let genderId;

      if (data.location) {
        location = data.location.name.split(',')[0];
      }
      const gender = GENDER[data.gender.toLowerCase()];

      if (gender) {
        genderId = gender.id;
      }

      return {
        facebook_access_token: data.access_token,
        cover: data.cover ? data.cover.source : '',
        email: data.email,
        first_name: data.first_name,
        gender: genderId,
        facebook_id: data.id,
        last_name: data.last_name,
        location: location,
        facebook_name: data.name,
        avatar: (data.picture && data.picture.data) ? data.picture.data.url : ''
      };
    }
  }
};
</script>

<style lang="scss">
  .facebook-button {
    img {
      width: 39px;
      top: -2px;
      position: relative;
      height: 39px;
    }
  }
</style>
