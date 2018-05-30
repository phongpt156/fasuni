<template>
  <div class="lookbook-item">
    <div>
      <img :src="lookbook.image" class="w-100 h-100" />
    </div>
    <div class="product-list-wrapper">
      <div class="d-flex align-items-center justify-content-center h-100">
        <div class="text-center">
          <p class="h4 text-uppercase">{{ lookbook.name }}</p>
          <hr class="w-25" />
          <a>
            <div v-for="product in lookbook.products" :key="product.id" class="product-item">
                <span class="product-name mr-2">{{ product.name }}</span>
              <span class="font-weight-bold">{{ priceFormat(product.price) }}</span>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getFormatPrice } from '@/shared/functions';

export default {
  props: {
    lookbook: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  data() {
    return {

    };
  },
  computed: {
    priceFormat() {
      return (price) => getFormatPrice(price);
    }
  }
};
</script>

<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';

  .lookbook-item {
    position: relative;
    &:hover {
      &:after {
        transition: opacity .15s ease 0s;
        opacity: 1;
      }

      .product-list-wrapper {
        transform: scale(1);
        opacity: 1;
      }
    }
    &:after {
      width: 100%;
      top: 0;
      transition: opacity .22s ease .22s;
      position: absolute;
      opacity: 0;
      left: 0;
      height: 100%;
      display: block;
      content: "";
      background: none repeat scroll 0 0 rgba(0, 0, 0, 0.35);
    }

    .product-list-wrapper {
      z-index: 1000;
      top: 0;
      transition: all linear .2s;
      transform: scale(0.8);
      right: -1px;
      position: absolute;
      overflow: hidden;
      opacity: 0;
      left: 0;
      color: rgba(255, 255, 255, .8);
      bottom: -1px;

      .product-item {
        &:hover {
          color: $white;
        }
      }
    }
    hr {
      border-top: 2px solid #f6f5f5;
    }
  }
</style>
