<template>
  <div>
    <row type="flex" justify="center">
      <i-col>
        <i-form ref="loginForm" :model="loginForm" :rules="rules">
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
          <form-item>
            <i-button type="primary" @click="login">Signin</i-button>
          </form-item>
        </i-form>
      </i-col>
    </row>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex';

export default {
  data() {
    return {
      loginForm: {
        email: 'pthanhphong156@gmail.com',
        password: '123456'
      },
      rules: {
        email: [
          { required: true, message: '', trigger: 'blur' },
          { type: 'email', message: '', trigger: 'blur' }
        ],
        password: [
          { required: true, message: '', trigger: 'blur' }
        ]
      }
    };
  },
  computed: {
    ...mapState('constants', [
      'errorMessage'
    ])
  },
  methods: {
    ...mapMutations('auth', [
      'setToken'
    ]),
    login() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.$Message.success('Success');
          this.$store.dispatch('services/auth/login', this.loginForm)
            .then(response => {
              if (response && response.status === 200 && response.data) {
                this.setToken(response.data.api_token);
              }
            });
        } else {
          this.$Message.error('Fail!');
        }
      });
    },
    setErrorMessage() {
      this.rules.email[0].message = this.errorMessage.email.required;
      this.rules.email[1].message = this.errorMessage.email.type;
      this.rules.password[0].message = this.errorMessage.password.required;
    }
  },
  mounted() {
    this.setErrorMessage();
  }
};
</script>
