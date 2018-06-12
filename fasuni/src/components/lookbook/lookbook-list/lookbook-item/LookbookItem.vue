<template>
  <div class="lookbook-item">
    <div>
      <responsive-image :lg="lookbook.large_image" :md="lookbook.medium_image" :sm="lookbook.small_image" :thumbnail="lookbook.thumbnail" image-class="w-100 h-100" ></responsive-image>
    </div>
    <div class="product-list-wrapper">
      <div class="d-flex align-items-center justify-content-center h-100">
        <div class="text-center">
          <p class="h4 text-uppercase">{{ lookbook.name }}</p>
          <hr class="w-25" />
          <a>
            <router-link v-for="product in lookbook.products" :key="product.id" class="product-item d-block" :to="{name: 'Product', params: {id: product.id}, query: product.color ? {color: product.color.id} : {}}">
              <span class="product-name mr-2">{{ product.name }}</span>
              <span class="font-weight-bold">{{ priceFormat(product.sale_price) }}</span>
            </router-link>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getFormatPrice } from '@/shared/functions';
import ResponsiveImage from '@/components/shared/responsive-image/ResponsiveImage';

export default {
  components: {
    ResponsiveImage
  },
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
      transition: opacity .2s ease 0s;
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
    transition: opacity .2s ease .2s;
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
      color: hsla(0, 0%, 100%, .8);

      &:hover {
        color: $white;
      }
    }
  }
  hr {
    border-top: 2px solid #f6f5f5;
  }
  a {
    &:hover {
      text-decoration: none;
    }
  }
}
</style>
