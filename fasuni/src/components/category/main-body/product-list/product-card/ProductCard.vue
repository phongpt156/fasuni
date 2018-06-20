<template>
  <div class="product-card h-100">
    <div class="card h-100">
      <div class="card-header p-0">
        <template v-if="sizes && sizes.length">
          <router-link class="image-wrapper image-standard d-block" :to="{name: 'Product', params: {id: product.id}, query: sizes[0].product.color ? {color: sizes[0].product.color.id} : {}}">
            <img class="card-img-top img-fluid" :src="images[0].original" :alt="product.name" v-if="images && images.length" />
            <img class="card-img-top img-fluid" :alt="sizes[0].product.name" v-else />
          </router-link>
        </template>
        <template v-else>
          <router-link class="image-wrapper image-standard d-block" :to="{name: 'Product', params: {id: product.id}}">
            <img class="card-img-top img-fluid" :src="images[0].original" :alt="product.name" v-if="images && images.length" />
            <img class="card-img-top img-fluid" :alt="product.name" v-else />
          </router-link>
        </template>
        <font-awesome-icon
          :icon="icon.heart"
          class="like-button"
          @click="toggleLiked"></font-awesome-icon>
        <div class="product-attributes w-100">
          <div class="product-quantity-info mx-3 mb-3" v-if="currentHoverSize !== null">
            <div class="bg-white py-2 text-center">
              {{ productSizeQuantityStatus }}
            </div>
          </div>
          <div class="size-list w-100 justify-content-center py-1 d-none">
            <div
              v-for="size in sizes"
              :key="size.id"
              class="px-2 size-item"
              @mouseenter="enterProductSize(size)"
              @mouseleave="leaveProductSize"
              @click="addProductToCart({images, product: size.product})">
                {{ size.name }}
            </div>
          </div>
        </div>
      </div>
      <div class="card-body px-1 py-1">
        <div class="text-uppercase name py-1">{{ product.name }}</div>
        <div class="ml-auto price pb-1">{{ product.sale_price | priceFormat }}</div>
        <div class="d-flex align-items-center">
          <a v-for="color in colors" :key="color.id">
            <div
              class="color mr-2"
              :class="{active: currentColor === color}"
              @click="selectColor(color)"
              :style="{'background-color': color.value}">
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { priceFormat } from '@/filters';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import solidFaHeart from '@fortawesome/fontawesome-free-solid/faHeart';
import regularFaHeart from '@fortawesome/fontawesome-free-regular/faHeart';
import { mapState, mapMutations } from 'vuex';
import userProductCommunication from '@/shared/services/user-product-communication.service';

export default {
  name: 'ProductCard',
  filters: {
    priceFormat
  },
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
      currentColor: null
    };
  },
  computed: {
    ...mapState(['user']),
    icon() {
      let heart;

      if (this.selectedProduct.liked) {
        heart = solidFaHeart;
      } else {
        heart = regularFaHeart;
      }

      return {
        heart
      };
    },
    productSizeQuantityStatus() {
      if (this.currentHoverSize !== null) {
        let status = `Size ${this.currentHoverSize.name}`;

        if (this.currentHoverSize.product.total_quantity) {
          status += ` - Còn hàng`;
        } else {
          status += ' - Đã hết hàng';
        }
        return status;
      }
    },
    colors() {
      const colors = [];

      if (this.product.color) {
        colors.push(this.product.color);
      }

      this.product.sub_products.forEach(subProduct => {
        if (subProduct.color) {
          const existColor = colors.find(color => color.id === subProduct.color.id);

          if (!existColor) {
            colors.push(subProduct.color);
          }
        }
      });

      return colors;
    },
    sizes() {
      const sizes = [];

      if (this.currentColor) {
        if (this.product.size && this.product.color && this.product.color.id === this.currentColor.id) {
          const size = Object.assign({}, this.product.size);
          size.product = this.product;
          sizes.push(size);
        }

        this.product.sub_products.forEach(subProduct => {
          if (subProduct.size && subProduct.color && subProduct.color.id === this.currentColor.id) {
            const size = Object.assign({}, subProduct.size);
            size.product = subProduct;
            sizes.push(size);
          }
        });
      } else {
        if (this.product.size) {
          const size = Object.assign({}, this.product.size);
          size.product = this.product;
          sizes.push(size);
        }

        this.product.sub_products.forEach(subProduct => {
          if (subProduct.size && this.product.size) {
            const existSize = sizes.find(size => size.id === subProduct.size.id);

            if (!existSize) {
              const size = Object.assign({}, subProduct.size);
              size.product = subProduct;
              sizes.push(size);
            }
          }
        });
      }

      return sizes;
    },
    images() {
      let images = [];

      for (const size of this.sizes) {
        if (size.product.images && size.product.images.length) {
          images = size.product.images;

          return images;
        }
      }

      if (this.colors.length) {
        if (this.product.images && this.product.images.length && this.currentColor && this.product.color && this.currentColor.id === this.product.color.id) {
          for (const image of this.product.images) {
            images.push(image);
          }

          return images;
        }
      }

      if (this.product.images && this.product.images.length) {
        for (const image of this.product.images) {
          images.push(image);
        }

        return images;
      }

      if (!this.sizes.length && this.product.sub_products) {
        for (const subProduct of this.product.sub_products) {
          if (subProduct.images.length) {
            for (const image of (subProduct.images)) {
              images.push(image);
            }
            break;
          }
        }
      }

      return images;
    },
    selectedProduct() {
      if (this.sizes && this.sizes.length) {
        return this.sizes[0].product;
      }
      return this.product;
    }
  },
  methods: {
    ...mapMutations('cart', {
      addProductToCart: 'add'
    }),
    ...mapMutations('products', {
      'toggleLikedState': 'toggleLiked'
    }),
    enterProductSize(size) {
      this.currentHoverSize = size;
      this.currentHoverSize.total_quantity = size.product.total_quantity;
    },
    leaveProductSize() {
      this.currentHoverSize = null;
    },
    toggleLiked() {
      if (this.user) {
        this.toggleLikedState(this.selectedProduct);

        if (this.selectedProduct.liked) {
          userProductCommunication.like(this.selectedProduct.id);
        } else {
          userProductCommunication.dislike(this.selectedProduct.id);
        }
      } else {
        alert('Hãy đăng nhập trước');
      }
    },
    selectColor(color) {
      this.currentColor = color;
    }
  },
  mounted() {
    if (this.colors.length) {
      this.currentColor = this.colors[0];
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
    font-size: .75rem;
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

        &:hover {
          color: #707070;
        }
      }
    }
  }
}
</style>
