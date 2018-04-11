<template>
  <div class="login-form-dialog">
    <modal
      v-if="isOpenLoginFormDialog"
      @close="$emit('update:isOpenLoginFormDialog', false)">
      <div slot="body" class="row m-0">
        <div class="col-6 p-0">
          <img :src="images.loginFormBanner" alt="" class="w-100 h-100" />
        </div>
        <div class="col-6 px-lg-5 pt-lg-3">
          <h5 class="text-center">Fasuni</h5>
          <mat-form
            ref="loginForm"
            :model="loginForm"
            :rules="loginRules"
            @submit="onSubmit">
            <div>
              <mat-input
                label="Số điện thoại"
                placeholder="Nhập số điện thoại của bạn"
                :required="true"
                type="text"
                v-model="loginForm.phone_number"
                prop="phone_number">
              </mat-input>
            </div>
            <div>
              <mat-input
                label="Mật khẩu"
                placeholder="Nhập mật khẩu"
                :required="true"
                type="password"
                v-model="loginForm.password"
                prop="password"></mat-input>
            </div>
            <a class="d-block text-right mb-3 text-underline forget-password-button">Quên mật khẩu</a>
            <button type="submit" class="btn w-100 submit-button text-white">Đăng nhập</button>
          </mat-form>
          <p class="text-center my-2">Hoặc</p>
          <div class="social d-flex justify-content-center mb-2">
            <a class="d-inline-block mr-3">
              <font-awesome-icon :icon="icons.google"></font-awesome-icon>
            </a>
            <facebook-button></facebook-button>
          </div>
          <p class="text-center">Bạn chưa có tài khoản?
            <a class="register-button" @click="$emit('openRegisterFormDialog')">Đăng ký ngay</a>
          </p>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import MatInput from '@/components/shared/material/MatInput';
import MatForm from '@/components/shared/material/MatForm';
import Modal from '@/components/shared/Modal';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import googleIcon from '@fortawesome/fontawesome-free-brands/faGooglePlus';
import { mapMutations } from 'vuex';
import loginFormBanner from '@/assets/images/login-form-banner.jpg';
import FacebookButton from '@/components/shared/FacebookButton';
import { ERROR_MESSAGE, PATTERN } from '@/shared/constants';
import userService from '@/shared/services/user.service';
import { reloadApp } from '@/shared/functions';

export default {
  props: {
    dialog: {
      type: Boolean,
      default: false
    },
    isOpenLoginFormDialog: {
      type: Boolean,
      default: false
    }
  },
  components: {
    MatInput,
    MatForm,
    FontAwesomeIcon,
    Modal,
    FacebookButton
  },
  data() {
    return {
      loginForm: {
        phone_number: '',
        password: ''
      },
      loginRules: {
        phone_number: [
          { required: true, message: ERROR_MESSAGE.phoneNumber.required },
          { validator: PATTERN.phoneNumber, message: ERROR_MESSAGE.phoneNumber.format }
        ],
        password: [
          { required: true, message: ERROR_MESSAGE.password.required }
        ]
      },
      images: {
        loginFormBanner: loginFormBanner
      },
      icons: {
        google: googleIcon
      }
    };
  },
  methods: {
    ...mapMutations('auth', [
      'setToken'
    ]),
    onSubmit() {
      this.$refs.loginForm.validate();
      if (this.$refs.loginForm.isValid) {
        userService.login(this.loginForm)
          .then(response => {
            if (response.status === 200) {
              this.setToken(response.data.api_token);
              reloadApp();
            } else {
              this.addErrors(response.data.errors);
            }
          });
      }
    },
    addErrors(errors) {
      for (const key of Object.keys(errors)) {
        this.$refs.loginForm.addError(key, errors[key]);
      }
    }
  }
};
</script>

<style lang="scss">
  .login-form-dialog {
    .submit-button {
      border-radius: 50px;
      background-color: #ff7eaf;
    }
    .fa-google-plus {
      color: #fb5245;
    }
    .social {
      a {
        .svg-inline--fa {
          width: 35px;
          height: 35px;
        }
      }
    }
    .register-button {
      color: #ff758c !important;

      &:hover {
        text-decoration: underline !important;
      }
    }
    .forget-password-button {
      &:hover {
        text-decoration: underline !important;
      }
    }
  }
</style>
