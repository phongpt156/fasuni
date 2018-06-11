<template>
  <div class="product-list">
    <div class="row mx-2 mt-2">
      <template v-if="products.length">
        <div v-for="product in products" :key="product.id" class="col-xl-3 col-sm-6 px-3 my-3">
          <product-card :product="product"></product-card>
        </div>
      </template>
      <h3 v-else class="text-center col-12">Không tìm thấy sản phẩm</h3>
      <div class="w-100 d-flex justify-content-center">
        <spinner class="mt-3" :loading="loading"></spinner>
      </div>
    </div>
  </div>
</template>

<script>
import ProductCard from './product-card/ProductCard';
import Spinner from '@/components/shared/spinner/Spinner';
import { mapState } from 'vuex';

export default {
  name: 'ProductList',
  components: {
    ProductCard,
    Spinner
  },
  computed: {
    ...mapState('products', [
      'loading',
      'products'
    ])
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.product-list {
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .fa-spinner {
    font-size: 2rem;
    animation: spin 2s linear infinite;
  }
}
</style>
