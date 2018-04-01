<template>
  <div>
    <i-form ref="loginForm" :model="loginForm" :rules="rules" inline>
      <form-item prop="email">
        <i-input type="text" v-model="loginForm.email" placeholder="Email">
          <Icon type="ios-person-outline" slot="prepend"></Icon>
        </i-input>
      </form-item>
      <form-item prop="password">
        <i-input type="text" v-model="loginForm.password" placeholder="Password">
          <icon type="ios-locked-outline" slot="prepend"></icon>
        </i-input>
      </form-item>
      <div>
        <form-item>
          <i-button type="primary" @click="login">Signin</i-button>
        </form-item>
      </div>
    </i-form>
  </div>
</template>

<script>
import { ERROR_MESSAGE } from './../constants/error-message';

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
    login() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.$Message.success('Success');
        } else {
          this.$Message.error('Fail!');
        }
      });
    }
  }
};
</script>
