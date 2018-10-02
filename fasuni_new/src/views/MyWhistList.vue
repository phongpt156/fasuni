<template>
  <div class="my-whistlist py-5">
    <h5 class="text-center">Sản phẩm yêu thích của bạn</h5>
    <div class="row mx-4 px-1 mt-2">
      <product-card v-for="product in products" :key="product.id" :product="product" class="col-xl-3 col-sm-6 py-4 px-3"></product-card>
    </div>
  </div>
</template>

<script>
import userService from '@/shared/services/user.service';
import ProductCard from '@/components/my-whistlist/ProductCard';

export default {
  components: {
    ProductCard
  },
  data() {
    return {
      products: []
    };
  },
  methods: {
    getWhistlist(page = 1) {
      userService.getWhistlist(page)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.products = response.data.data;
          }
        });
    }
  },
  mounted() {
    this.getWhistlist(1);
  }
};
</script>

<style lang="scss">
.my-whistlist {
  min-height: calc(100vh - 322px);
}
</style>
