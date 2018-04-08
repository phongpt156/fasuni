<template>
  <div class="register-form-dialog">
    <modal
      v-if="isOpenRegisterFormDialog"
      @close="$emit('update:isOpenRegisterFormDialog', false)">
      <div slot="body" class="row m-0">
        <div class="col-6 p-0">
          <img :src="images.registerFormBanner" alt="" class="w-100 h-100" />
        </div>
        <div class="col-6 px-lg-5 pt-lg-3">
          <h5 class="text-center">Fasuni</h5>
          <mat-form>
            <div>
              <mat-input
                label="Số điện thoại"
                placeholder="Nhập số điện thoại của bạn"
                :required="true"
                type="text"
                v-model="phoneNumber"></mat-input>
            </div>
            <div>
              <mat-input
                label="Họ tên"
                placeholder="Nhập họ tên đầy đủ"
                :required="true"
                type="text"
                v-model="fullName"></mat-input>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <mat-select
                  label="Tỉnh thành"
                  placeholder="Chọn tỉnh thành"
                  :required="true"
                  type="text"
                  v-model="province"></mat-select>
              </div>
              <div class="col-lg-6">
                <mat-select
                  label="Giới tính"
                  placeholder="Chọn giới tính"
                  :required="true"
                  type="text"
                  v-model="gender">
                  <option v-for="gender in genders" :key="gender.id" slot="option" class="text-dark">
                    {{ gender.name }}
                  </option>
                </mat-select>
              </div>
            </div>
            <div>
              <mat-input
                label="Mật khẩu"
                placeholder="Nhập mật khẩu"
                :required="true"
                type="password"
                v-model="password"></mat-input>
            </div>
            <button type="button" class="btn w-100 submit-button text-white">Đăng ký</button>
          </mat-form>
          <p class="text-center my-2">Hoặc</p>
          <div class="social d-flex justify-content-center mb-2">
            <a class="d-inline-block mr-3">
              <font-awesome-icon :icon="icons.google"></font-awesome-icon>
            </a>
            <a class="d-inline-block">
              <img :src="images.facebook" alt="" />
            </a>
          </div>
          <p class="text-center">Bạn đã có tài khoản?
            <a class="register-button" @click="$emit('openLoginFormDialog')">Đăng nhập ngay</a>
          </p>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import MatInput from '@/components/shared/material/MatInput';
import MatSelect from '@/components/shared/material/MatSelect';
import MatForm from '@/components/shared/material/MatForm';
import Modal from '@/components/shared/Modal';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import googleIcon from '@fortawesome/fontawesome-free-brands/faGooglePlus';
import registerFormBanner from '@/assets/images/register-form-banner.jpg';
import facebookIcon from '@/assets/images/facebook-icon.svg';
import { GENDER } from '@/shared/constants';

export default {
  props: {
    dialog: {
      type: Boolean,
      default: false
    },
    isOpenRegisterFormDialog: {
      type: Boolean,
      default: false
    }
  },
  components: {
    MatInput,
    MatSelect,
    MatForm,
    FontAwesomeIcon,
    Modal
  },
  data() {
    return {
      phoneNumber: '',
      fullName: '',
      province: '',
      gender: '',
      password: '',
      images: {
        registerFormBanner: registerFormBanner,
        facebook: facebookIcon
      },
      icons: {
        google: googleIcon
      }
    };
  },
  computed: {
    genders() {
      return GENDER;
    }
  }
};
</script>

<style lang="scss">
  .register-form-dialog {
    .modal-lg {
      &>.row {
        overflow-y: auto;
        max-height: 535px;
      }
    }
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
