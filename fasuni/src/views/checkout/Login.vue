<template>
  <div class="mt-5 py-5 d-flex align-items-center justify-content-center">
    <button class="btn btn-success mr-3" @click="openLoginFormDialog">Đăng nhập</button>
    <button class="btn btn-alert" @click="openRegisterFormDialog">Đăng ký</button>
    <login-form-dialog :isOpenLoginFormDialog.sync="isOpenLoginFormDialog" @openRegisterFormDialog="openRegisterFormDialog"></login-form-dialog>
    <register-form-dialog :isOpenRegisterFormDialog.sync="isOpenRegisterFormDialog" @openLoginFormDialog="openLoginFormDialog"></register-form-dialog>
  </div>
</template>

<script>
import LoginFormDialog from '@/components/shared/LoginFormDialog';
import RegisterFormDialog from '@/components/shared/RegisterFormDialog';

export default {
  components: {
    LoginFormDialog,
    RegisterFormDialog
  },
  data() {
    return {
      isOpenLoginFormDialog: false,
      isOpenRegisterFormDialog: false
    };
  },
  methods: {
    openRegisterFormDialog() {
      this.isOpenLoginFormDialog = false;
      this.isOpenRegisterFormDialog = true;
    },
    openLoginFormDialog() {
      this.isOpenLoginFormDialog = true;
      this.isOpenRegisterFormDialog = false;
    }
  }
};
</script>

<style>

</style>
