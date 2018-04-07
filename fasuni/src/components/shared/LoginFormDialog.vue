<template>
  <div class="modal fade login-form-dialog" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body row p-0 m-0">
          <div class="col-6 p-0">
            <img :src="images.loginFormBanner" alt="" class="img-fluid" />
          </div>
          <div class="col-6 px-5 pt-5">
            <h5 class="text-center">Fasuni</h5>
            <form>
              <div>
                <div class="font-weight-bold text-upppercase">Số điện thoại</div>
                <mat-input
                  placeholder="Nhập số điện thoại của bạn"
                  :required="true"
                  type="text"
                  v-model="phoneNumber"></mat-input>
              </div>
              <div>
                <div class="font-weight-bold text-upppercase">Mật khẩu</div>
                <mat-input
                  placeholder="Nhập mật khẩu"
                  :required="true"
                  type="password"
                  v-model="password"></mat-input>
              </div>
              <button type="button" class="btn w-100 submit-button text-white">Đăng nhập</button>
            </form>
            <p class="text-center my-2">Hoặc</p>
            <div class="social d-flex justify-content-center mb-2">
              <a class="d-inline-block mr-3">
                <font-awesome-icon :icon="icons.google"></font-awesome-icon>
              </a>
              <a class="d-inline-block">
                <img :src="images.facebook" alt="" />
              </a>
            </div>
            <p class="text-center">Bạn chưa có tài khoản? <span class="register-button">Đăng ký ngay</span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MatInput from '@/components/shared/material/MatInput';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import googleIcon from '@fortawesome/fontawesome-free-brands/faGooglePlus';
import loginFormBanner from '@/assets/images/login-form-banner.jpg';
import facebookIcon from '@/assets/images/facebook-icon.svg';

export default {
  props: {
    dialog: {
      type: Boolean,
      default: false
    }
  },
  components: {
    MatInput,
    FontAwesomeIcon
  },
  data() {
    return {
      phoneNumber: '',
      password: '',
      images: {
        loginFormBanner: loginFormBanner,
        facebook: facebookIcon
      },
      icons: {
        google: googleIcon
      }
    };
  },
  methods: {
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
        img {
          width: 39px;
          top: -2px;
          position: relative;
          height: 39px;
        }
      }
    }
    .register-button {
      color: #ff758c;
    }
  }
</style>
