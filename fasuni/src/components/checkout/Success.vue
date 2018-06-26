<template>
  <div class="container checkout-success bg-white border rounded py-4 mt-5">
    <p class="text-danger mb-0">Cảm ơn bạn đã mua hàng tại Fasuni</p>
    <small>Mã số đơn hàng của bạn</small>
    <br />
    <div class="code d-inline-block text-white px-4 py-2 my-2">
      {{ code }}
    </div>
    <p class="mb-0"><small>Bạn có thể xem lại <router-link :to="{name: 'ViewOrder', query: {code: this.code}}">đơn hàng của tôi</router-link></small></p>
    <p class="mb-0"><small>Thời gian giao hàng dự kiến: </small></p>
  </div>
</template>

<script>
export default {
  computed: {
    code() {
      return this.$route.query.code;
    }
  }
};
</script>

<style lang="scss">
.checkout-success {
  .code {
    background: rgb(0, 113, 56);
  }
}
</style>
