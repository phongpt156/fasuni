<template>
  <div class="checkout pb-5">
    <form-wizard step-size="xs" class="w-lg-50 mx-auto pb-0" color="#007138" ref="formWizard" title="Thông tin giao hàng" subtitle="">
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
      </tab-content>
      <tab-content
        title="Địa chỉ giao hàng"
        icon="ti-settings">
      </tab-content>
      <tab-content
        title="Thanh toán và đặt mua"
        icon="ti-check">
      </tab-content>
      <template slot="footer">
        <div></div>
      </template>
    </form-wizard>
    <router-view></router-view>
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
  computed: {
    ...mapState([
      'user'
    ]),
    ...mapState('cart', [
      'products'
    ]),
    step() {
      return this.$route.meta.step;
    }
  },
  watch: {
    user(newValue) {
      if (!newValue) {
        this.$router.push({name: 'CheckoutLogin'});
      } else if (this.$route.name === 'Checkout' || this.$route.name === 'CheckoutLogin') {
        this.$router.push({name: 'CheckoutShipping'});
      }
    },
    step (newValue, oldValue) {
      this.$refs.formWizard.changeTab(oldValue, newValue);
    }
  },
  mounted() {
    if (this.products.length) {
      if (this.$route.meta.step === 2) {
        this.$refs.formWizard.changeTab(0, 1);
        this.$refs.formWizard.changeTab(1, 2);
      }

      if (!this.user) {
        this.$router.push({name: 'CheckoutLogin'});
      } else if (this.$route.name === 'Checkout' || this.$route.name === 'CheckoutLogin') {
        this.$router.push({name: 'CheckoutShipping'});
      }
    } else {
      this.$router.push({name: 'Homepage'});
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
  .wizard-tab-content {
    display: none;
  }
}
</style>
