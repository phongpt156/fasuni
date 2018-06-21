<template>
  <div class="checkout">
    <form-wizard step-size="xs" class="w-lg-50 mx-auto" color="#007138" ref="formWizard" title="Thông tin giao hàng" subtitle="">
      <tab-content
        title="Đăng nhập"
        icon="ti-user">
      </tab-content>
      <tab-content
        title="Địa chỉ giao hàng"
        icon="ti-settings">
        <shipping @submit="step = 2"></shipping>
      </tab-content>
      <tab-content
        title="Thanh toán và đặt mua"
        icon="ti-check">
        123
      </tab-content>
      <template slot="footer">
        <div></div>
      </template>
    </form-wizard>
  </div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard';
import Shipping from './Shipping';
import { mapState } from 'vuex';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';
import '@/assets/styles/themify-icons.css';

export default {
  components: {
    FormWizard,
    TabContent,
    Shipping
  },
  data() {
    return {
      step: 0
    };
  },
  computed: {
    ...mapState([
      'user'
    ])
  },
  watch: {
    user(newValue) {
      if (newValue) {
        this.step = 1;
      }
    },
    step(newValue, oldValue) {
      this.$refs.formWizard.changeTab(oldValue, newValue);
    }
  },
  mounted() {
    if (this.user) {
      this.step = 1;
    }
  }
};
</script>

<style lang="scss">
.checkout {
  min-height: calc(100vh - 322px);

  .mat-form {
    .form-item {
      width: 500px;
    }
  }
  .btn-success {
    background-color: rgb(0, 113, 56);
  }
}
</style>
