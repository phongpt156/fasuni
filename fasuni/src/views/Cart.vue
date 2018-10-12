<template>
  <div class="cart px-sm-5">
    <h1 class="text-center">Giỏ hàng của bạn</h1>
    <div class="px-md-5 mt-5" v-if="products.length">
      <table class="w-100 px-2 text-center">
        <thead>
          <tr>
            <th scope="col" colspan="2" class="text-left pl-4 text-uppercase">Sản phẩm</th>
            <th scope="col" class="text-center text-uppercase">Màu sắc</th>
            <th scope="col" class="text-center text-uppercase">Size</th>
            <th scope="col" class="text-center text-uppercase">Số lượng</th>
            <th scope="col" class="text-center text-uppercase">Tổng tiền</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id" class="bg-white">
            <td style="width: 150px">
              <div class="image-wrapper image-standard">
                <img :src="product.images[0].original" :alt="product.name" class="w-100 h-100" v-if="product.images && product.images.length" />
              </div>
            </td>
            <td>{{ product.name }}</td>
            <td>
              <template v-if="product.color">
                <div class="color mx-auto" :style="{backgroundColor: product.color.value}"></div>
                <p class="mb-0 mt-2">{{ product.color.name }}</p>
              </template>
            </td>
            <td>
              <template v-if="product.size">
                {{ product.size.name }}
              </template>
              <template v-else>
                Free Size
              </template>
            </td>
            <td>
              <div class="number-input d-inline-block">
                <button type="button" class="number-input__button number-input__button--minus" @click="onChangeQuantity(product, product.quantity - 1)"></button>
                <input type="number" class="number-input__input font-size-base" :value="product.quantity" @change="onChangeQuantity(product, $event)" @input="inputQuantity(product, $event)" />
                <button type="button" class="number-input__button number-input__button--plus" @click="onChangeQuantity(product, product.quantity + 1)"></button>
              </div>
            </td>
            <td>{{ totalPricePerItem(product) | priceFormat }}</td>
            <td style="vertical-align: top">
              <div class="remove font-size-lg"><a @click="removeProductFromCart(index)">×</a></div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="text-right mt-3">
        <div>
          Tổng tiền: <span class="text-danger">{{ totalPrice | priceFormat }}</span>
        </div>
        <button class="payment my-3" @click="$router.push({name: 'Checkout'})">Đặt hàng</button>
      </div>
    </div>
    <h3 v-else class="text-center py-5">Giỏ hàng trống</h3>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex';
import { priceFormat } from '@/filters';

export default {
  filters: {
    priceFormat
  },
  computed: {
    ...mapState('cart', [
      'products'
    ]),
    totalPricePerItem() {
      return product => product.sale_price * product.quantity;
    },
    totalPrice() {
      let total = 0;
      this.products.forEach(product => {
        total += this.totalPricePerItem(product);
      });

      return total;
    }
  },
  methods: {
    ...mapMutations('cart', {
      removeProductFromCart: 'remove',
      updateQuantity: 'updateQuantity'
    }),
    onChangeQuantity(product, quantity) {
      this.updateQuantity({product, quantity});
    },
    inputQuantity(product, $event) {
      const quantity = Number($event.target.value);

      if (Number.isInteger(quantity) && quantity >= 0 && quantity <= 10000) {
        $event.target.value = quantity;
        this.onChangeQuantity(product, quantity);
      } else {
        $event.target.value = product.quantity;
      }
    }
  }
};
</script>

<style lang="scss">
.cart {
  min-height: calc(100vh - 322px);

  .color {
    width: 25px;
    height: 25px;
    border: 1px solid #000;
  }

  table {
    border-spacing: 0 10px;
    border-collapse: separate;
    background: #ddd;
  }
  .number-input {
    position: relative;

    &__button {
      width: 2.5rem;
      top: .0625rem;
      position: absolute;
      outline: none;
      cursor: pointer;
      bottom: .0625rem;
      border-radius: .25rem;
      border: 0;
      background-color: transparent;

      &--minus {
        left: .0625rem;
        border-top-right-radius: 0;
        border-right: .0625rem solid #ddd;
        border-bottom-right-radius: 0;

        &::after {
          visibility: hidden;
        }
      }
      &--plus {
        right: .0625rem;
        border-left: .0625rem solid #ddd;
      }

      &::before, &::after {
        transition: background-color .15s;
        transform: translate(-50%, -50%);
        top: 50%;
        position: absolute;
        left: 50%;
        content: "";
        background-color: #111;
      }
      &::before {
        width: 50%;
        height: .0625rem;
      }
      &::after {
        width: .0625rem;
        height: 50%;
      }
      &:hover {
        &::before, &::after {
          background-color: #0074d9;
        }
      }
    }

    input {
      width: 12.5rem;
      transition: border-color .15s;
      padding-right: 3.375rem;
      padding-left: 3.375rem;
      padding-top: .4375rem;
      padding-bottom: .4375rem;
      min-width: 3rem;
      min-height: 1.5rem;
      max-width: 100%;
      line-height: 1.5;
      display: inline-block;
      border-radius: .25rem;
      border: 1px solid #ddd;

      &:focus {
        outline: none;
        border-color: #0074d9;
      }
      &::-webkit-outer-spin-button, &::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
      }
    }
  }
  .payment {
    width: 12%;
    padding: 10px;
    outline: none;
    min-width: 150px;
    cursor: pointer;
    color: #fff;
    border-radius: 4px;
    border: 0;
    background-color: #007138;
  }
}
</style>
