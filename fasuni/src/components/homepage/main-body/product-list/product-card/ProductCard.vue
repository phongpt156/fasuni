<template>
  <div class="product-card mt-3 px-3">
    <div class="card">
      <div class="card-header p-0">
        <img class="card-img-top img-fluid" :src="product.image" />
        <font-awesome-icon
          :icon="icon.heart"
          class="like-button"
          @mouseenter="hoveredLikeButton = true"
          @mouseleave="hoveredLikeButton = false"></font-awesome-icon>
        <div class="product-attributes w-100">
          <div class="product-quantity-info mx-3 mb-3" v-if="currentHoverSize !== null">
            <div class="bg-white py-2 text-center">
              {{ productSizeQuantityStatus }}
            </div>
          </div>
          <div class="size-list w-100 justify-content-center py-1 d-none">
            <div
              v-for="size in product.sizes"
              :key="size.id"
              class="px-2 size-item"
              @mouseenter="enterProductSize(size)"
              @mouseleave="leaveProductSize">
              {{ size.name }}
            </div>
          </div>
        </div>
      </div>
      <div class="card-body px-1 py-1">
        <div class="d-flex">
          <div class="text-uppercase name">{{ product.name }}</div>
          <div class="ml-auto font-weight-bold price pl-3">{{ priceFormat(product.price) }}</div>
        </div>
        <div class="d-flex align-items-center">
          <div
            v-for="(color, index) in product.colors"
            :key="color.id"
            class="color mr-2"
            :class="{active: index === 0}"
            :style="{'background-color': color.code}">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getFormatPrice } from '@/shared/functions';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import solidFaHeart from '@fortawesome/fontawesome-free-solid/faHeart';
import regularFaHeart from '@fortawesome/fontawesome-free-regular/faHeart';

export default {
  name: 'ProductCard',
  props: {
    product: {
      type: Object,
      default: () => {
        return {};
      }
    }
  },
  components: {
    FontAwesomeIcon
  },
  data() {
    return {
      currentHoverSize: null,
      hoveredLikeButton: false
    };
  },
  computed: {
    icon() {
      let heart;

      if (this.hoveredLikeButton) {
        heart = solidFaHeart;
      } else {
        heart = regularFaHeart;
      }

      return {
        heart
      };
    },
    priceFormat() {
      return (price) => getFormatPrice(price);
    },
    productSizeQuantityStatus() {
      if (this.currentHoverSize !== null) {
        let status = `Size ${this.currentHoverSize.name}`;

        if (this.currentHoverSize.quantity) {
          status += ' - Còn hàng';
        } else {
          status += ' - Đã hết hàng';
        }
        return status;
      }
    }
  },
  methods: {
    enterProductSize(size) {
      this.currentHoverSize = size;
    },
    leaveProductSize() {
      this.currentHoverSize = null;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';

  .product-card {
    font-size: $font-size-sm;
    .price {
      white-space: nowrap;
    }
    .color {
      width: 13px;
      height: 13px;
      border: 1px solid $black;

      &.active {
        width: 18px;
        height: 18px;
      }
    }
    .card {
      &:hover {
        box-shadow: 0 2px 7px rgba(0,0,0,.15);
      }

      .card-header {
        position: relative;
        cursor: pointer;

        &:hover {
          .size-list {
            display: flex !important;
          }
        }

        .product-attributes {
          position: absolute;
          left: 0;
          bottom: 0;
        }
        .size-list {
          background-color: rgba(255, 255, 255, .8);

          .size-item {
            &:hover {
              font-weight: $font-weight-bold;
            }
          }
        }
        .like-button {
          position: absolute;
          top: 10px;
          right: 10px;
          font-size: 20px;
        }
      }
    }
  }
</style>
