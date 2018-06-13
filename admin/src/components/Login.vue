<template>
  <div>
    <row type="flex" justify="center">
      <i-col>
        <i-form ref="loginForm" :model="loginForm" :rules="rules" @submit.native.prevent>
          <form-item prop="email">
            <i-input type="text" v-model="loginForm.email" placeholder="Email">
              <Icon type="ios-person-outline" slot="prepend"></Icon>
            </i-input>
          </form-item>
          <form-item prop="password">
            <i-input type="password" v-model="loginForm.password" placeholder="Password">
              <icon type="ios-locked-outline" slot="prepend"></icon>
            </i-input>
          </form-item>
          <form-item>
            <i-button type="primary" @click="onSubmit">Signin</i-button>
          </form-item>
        </i-form>
      </i-col>
    </row>
  </div>
</template>

<script>
import { ERROR_MESSAGE } from '@/shared/constants';
import authService from '@/shared/services/auth.service';
import { mapMutations } from 'vuex';

export default {
  data() {
    return {
      loginForm: {
        email: '',
        password: ''
      },
      rules: {
        email: [
          { required: true, message: ERROR_MESSAGE.email.required, trigger: 'blur' },
          { type: 'email', message: ERROR_MESSAGE.email.type, trigger: 'blur' }
        ],
        password: [
          { required: true, message: ERROR_MESSAGE.password.required, trigger: 'blur' }
        ]
      }
    };
  },
  methods: {
    ...mapMutations('auth', [
      'setToken'
    ]),
    onSubmit() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.$Message.success('Success');
          authService.login(this.loginForm)
            .then(response => {
              if (response && response.data && response.status === 200) {
                this.setToken(response.data.api_token);
                this.redirectToHomepage();
              } else {
                this.addErrors(response.data.errors);
              }
            });
        } else {
          this.$Message.error('Fail!');
        }
      });
    },
    addErrors(errors) {
      for (const key of Object.keys(errors)) {
        this.$refs.loginForm.addError(key, errors[key]);
      }
    },
    redirectToHomepage() {
      this.$router.push({'name': 'Homepage'});
    }
  }
};
</script>
