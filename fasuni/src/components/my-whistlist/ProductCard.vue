<template>
  <div class="whistlist-product-card">
    <div class="product-card h-100">
      <div class="card h-100">
        <div class="card-header p-0">
          <a href="/product/245?color=38" class="image-wrapper image-standard d-block">
            <img alt="Sơ mi T-283-S" class="card-img-top img-fluid" :src="image.original" />
          </a>
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
    priceFormat
  },
  props: {
    product: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  computed: {
    image() {
      if (this.product.images.length) {
        return this.product.images[0];
      }

      if (this.product.master_product && this.product.master_product.images.length && this.product.master_product.color.length && this.product.master_product.color[0].id === this.color.id) {
        return this.product.master_product.images[0];
      }

      for (const subProduct of this.product.sub_products) {
        if (subProduct.images.length && subProduct.color.length && subProduct.color[0].id === this.color.id) {
          return subProduct.images[0];
        }
      }

      return '';
    },
    color() {
      if (this.product.color.length) {
        return this.product.color[0];
      }

      return null;
    }
  }
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
