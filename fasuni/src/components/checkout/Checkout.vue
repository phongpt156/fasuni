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
      </tab-content>
      <tab-content
        title="Thanh toán và đặt mua"
        icon="ti-check">
      </tab-content>
      <template slot="footer">
        <div></div>
      </template>
    </form-wizard>
  </div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';
import '@/assets/styles/themify-icons.css';
import { mapState } from 'vuex';
import userService from '@/shared/services/user.service';

export default {
  components: {
    FormWizard,
    TabContent
  },
  computed: {
    ...mapState([
      'user'
    ])
  },
  watch: {
    user(newValue) {
      if (newValue) {
        this.$refs.formWizard.changeTab(0, 1);
        this.getDeliveryInfo();
      }
    }
  },
  methods: {
    getDeliveryInfo() {
      userService.getDeliveryInfo()
        .then(response => {
          console.log(response);
        });
    }
  },
  mounted() {
    if (this.user) {
      this.$refs.formWizard.changeTab(0, 1);
      this.getDeliveryInfo();
    }
  }
};
</script>

<style lang="scss">
.checkout {

}
</style>
