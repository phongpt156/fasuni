<template>
  <div class="cart-dialog bg-white p-3 shadow">
    <div class="product-list">
      <div v-for="product in products" :key="product.id" class="mb-3">
        <div class="row mx-0">
          <div class="col-5 px-0">
            <div class="image-wrapper image-standard px-0 h-100">
              <template v-if="product.images && product.images.length">
                <img :src="product.images[0].original" alt="" />
              </template>
            </div>
          </div>
          <div class="col-7 p-2 right">
            <p class="mb-0"><router-link :to="{name: 'Product', params: {id: product.id}}">{{ product.name }}</router-link></p>
            <p class="mb-0">Size: {{ product.size.name }}</p>
            <p class="mb-0">Số lượng: {{ product.quantity }}</p>
            <p class="mb-0">Tổng tiền: {{ totalPrice(product) | priceFormat }}</p>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <a>Xem giỏ hàng ({{ products.length }} sản phẩm)</a>
        <p class="mb-0">Tổng tiền: {{ totalBagPrice | priceFormat }}</p>
      </div>
      <button class="payment w-100">Thanh toán</button>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { priceFormat } from '@/filters';

export default {
  filters: {
    priceFormat
  },
  data() {
    return {
    };
  },
  computed: {
    ...mapState('cart', [
      'products'
    ]),
    totalPrice: () => product => {
      return product.sale_price * product.quantity;
    },
    totalBagPrice() {
      let total = 0;

      this.products.forEach(product => {
        total += product.sale_price * product.quantity;
      });

      return total;
    }
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.cart-dialog {
  top: 60px;
  right: 0;
  position: absolute;
  min-width: 14vw;
  font-size: .75rem;
  border: 1px solid $black;

  .right {
    background-color: #f2f2f2;
  }
  a {
    color: $black;
  }
  .payment {
    padding: 10px;
    cursor: pointer;
    color: $white;
    border-radius: 4px;
    border: 0;
    background-color: #007138;
  }
}
</style>
