<template>
  <div class="checkout">
    <form-wizard step-size="xs" class="w-lg-50 mx-auto" color="#007138" ref="formWizard" title="Thông tin giao hàng" subtitle="">
      <template slot="step" slot-scope="props">
        <wizard-step
          :tab="props.tab"
          :key="props.tab.title"
          :index="props.index">
        </wizard-step>
      </template>
      <tab-content
        title="Đăng nhập"
        icon="ti-user">
        <login></login>
      </tab-content>
      <tab-content
        title="Địa chỉ giao hàng"
        icon="ti-settings">
        <shipping @submit="step = 2"></shipping>
      </tab-content>
      <tab-content
        title="Thanh toán và đặt mua"
        icon="ti-check">
      </tab-content>
      <template slot="footer">
        <div></div>
      </template>
    </form-wizard>
    <payment v-if="step === 2" @edit-delivery-detail="step = 1"></payment>
  </div>
</template>

<script>
import { FormWizard, TabContent, WizardStep } from 'vue-form-wizard';
import { mapState } from 'vuex';
import Shipping from './Shipping';
import Payment from './Payment';
import Login from './Login';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';
import '@/assets/styles/themify-icons.css';

export default {
  components: {
    FormWizard,
    TabContent,
    WizardStep,
    Shipping,
    Payment,
    Login
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
