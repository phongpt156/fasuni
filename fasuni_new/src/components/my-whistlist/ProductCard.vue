<template>
  <div class="whistlist-product-card">
    <div class="product-card h-100">
      <div class="card h-100">
        <div class="card-header p-0">
          <router-link :to="{name: 'Product', params: {id: product.master_product_id || product.id}, query: product.color ? {color: product.color.id} : {}}" class="image-wrapper image-standard d-block">
            <img alt="Sơ mi T-283-S" class="card-img-top img-fluid" :src="image.original" />
          </router-link>
        </div>
        <div class="card-body px-1 py-1 text-center">
          <div class="text-uppercase name py-3">{{ product.name }}</div>
          <div class="ml-auto price pb-3">{{ product.sale_price | priceFormat }}</div>
          <div
            v-if="color"
            class="color mx-auto mb-3"
            :style="{'background-color': color.value}">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { priceFormat } from '@/filters';

export default {
  filters: {
    priceFormat,
  },
  props: {
    product: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  computed: {
    image() {
      if (this.product.images.length) {
        return this.product.images[0];
      }

      if (this.product.master_product && this.product.master_product.images.length && this.product.master_product.color && this.product.master_product.color.id === this.color.id) {
        return this.product.master_product.images[0];
      }

      for (const subProduct of this.product.sub_products) {
        if (subProduct.images.length && subProduct.color && subProduct.color.id === this.color.id) {
          return subProduct.images[0];
        }
      }

      return '';
    },
    color() {
      if (this.product.color) {
        return this.product.color;
      }

      return null;
    },
  },
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.whistlist-product-card {
  font-size: $font-size-sm;

  .color {
    width: 22px;
    height: 22px;
    border: 1px solid $black;
  }
}
</style>
