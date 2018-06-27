<template>
  <div class="register-form-dialog">
    <modal
      v-if="isOpenRegisterFormDialog"
      @close="$emit('update:isOpenRegisterFormDialog', false)">
      <div slot="body" class="row m-0">
        <div class="col-6 p-0">
          <img :src="`${imageUrl}/register-form-banner.jpg`" alt="" class="w-100 h-100" />
        </div>
        <div class="col-6 px-lg-5 pt-lg-3">
          <h5 class="text-center branding-name">Fasuni</h5>
          <mat-form
            ref="registerForm"
            :model="registerForm"
            :rules="registerRules"
            @submit="onSubmit">
            <div>
              <mat-input
                label="Số điện thoại"
                placeholder="Nhập số điện thoại của bạn"
                :required="true"
                type="text"
                v-model="registerForm.phone_number"
                prop="phone_number"></mat-input>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <mat-input
                  label="Tên"
                  placeholder="Nhập tên của bạn"
                  :required="true"
                  type="text"
                  v-model="registerForm.first_name"
                  prop="first_name">
                </mat-input>
              </div>
              <div class="col-lg-6">
                <mat-input
                  label="Họ"
                  placeholder="Nhập họ của bạn"
                  :required="true"
                  type="text"
                  v-model="registerForm.last_name"
                  prop="last_name">
                </mat-input>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <mat-select
                  label="Tỉnh thành"
                  placeholder="Chọn tỉnh thành"
                  type="text"
                  v-model="registerForm.city_id">
                  <option
                    v-for="city in cities"
                    :value="city.id"
                    :key="city.id"
                    slot="option"
                    class="text-dark">
                    {{ city.name }}
                  </option>
                </mat-select>
              </div>
              <div class="col-lg-6">
                <mat-select
                  label="Giới tính"
                  placeholder="Chọn giới tính"
                  type="text"
                  v-model="registerForm.gender">
                  <option
                    v-for="gender in genders"
                    :value="gender.id"
                    :key="gender.id"
                    slot="option"
                    class="text-dark">
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
                v-model="registerForm.password"
                prop="password"></mat-input>
            </div>
            <button type="submit" class="btn w-100 submit-button text-white">Đăng ký</button>
          </mat-form>
          <p class="text-center my-2">Hoặc</p>
          <div class="social d-flex justify-content-center mb-2">
            <a class="d-inline-block mr-3">
              <font-awesome-icon :icon="icons.google"></font-awesome-icon>
            </a>
            <facebook-button></facebook-button>
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
import { mapMutations } from 'vuex';
import FacebookButton from '@/components/shared/FacebookButton';
import { ERROR_MESSAGE, PATTERN, GENDER, IMAGE_URL } from '@/shared/constants';
import cityService from '@/shared/services/city.service';
import userService from '@/shared/services/user.service';
import { reloadApp } from '@/shared/functions';

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
    Modal,
    FacebookButton
  },
  data() {
    return {
      icons: {
        google: googleIcon
      },
      registerForm: {
        phone_number: '',
        first_name: '',
        last_name: '',
        password: '',
        gender: '',
        city_id: ''
      },
      registerRules: {
        phone_number: [
          { required: true, message: ERROR_MESSAGE.phoneNumber.required },
          { validator: PATTERN.phoneNumber, message: ERROR_MESSAGE.phoneNumber.format }
        ],
        first_name: [
          { required: true, message: ERROR_MESSAGE.firstName.required }
        ],
        last_name: [
          { required: true, message: ERROR_MESSAGE.lastName.required }
        ],
        password: [
          { required: true, message: ERROR_MESSAGE.password.required }
        ]
      },
      cities: []
    };
  },
  computed: {
    genders() {
      return GENDER;
    },
    imageUrl() {
      return IMAGE_URL;
    }
  },
  methods: {
    ...mapMutations('auth', [
      'setToken'
    ]),
    onSubmit() {
      this.$refs.registerForm.validate();
      if (this.$refs.registerForm.isValid) {
        userService.register(this.registerForm)
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
        this.$refs.registerForm.addError(key, errors[key]);
      }
    }
  },
  mounted() {
    cityService.getAll()
      .then(response => {
        this.cities = response.data;
      });
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.register-form-dialog {
  font-size: $font-size-sm;
  font-family: Roboto;

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
  .mat-input-label, .mat-select-label {
    text-transform: uppercase;
    font-weight: bold;
  }
}
</style>
