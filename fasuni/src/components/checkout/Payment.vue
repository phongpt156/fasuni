<template>
  <div class="container payment mt-5">
    <div class="row mb-5 mt-5">
      <div class="col-md-8 bg-white border rounded py-4 mb-md-0 mb-3">
        <p>Hiện tại chúng tôi chỉ hỗ trợ hình thức thanh toán trực tiếp (nhận tiền khi quý khách đã nhận được hàng)</p>
        <mat-button type="submit" class="btn btn-success" placeholder="Đặt mua" :loading="loading" @click.native="onSubmit"></mat-button>
        <p><i>(Xin vui lòng kiểm tra lại đơn hàng trước khi Đặt Mua)</i></p>
      </div>
      <div class="col-md-4">
        <div class="bg-white border rounded p-3">
          <div class="d-flex justify-content-between align-items-center">
            <span>Địa chỉ giao hàng</span>
            <a class="px-3 py-2 rounded bg-white border" @click="$emit('edit-delivery-detail')">Sửa</a>
          </div>
          <div>
            <hr />
            <h6 class="font-weight-bold mb-2">{{ deliveryDetail.receiver_name }}</h6>
            <p class="mb-0">{{ fullAddress }}</p>
            <p class="mb-0">SĐT: {{ deliveryDetail.receiver_phone }}</p>
          </div>
        </div>
        <div class="bg-white border rounded p-3 mt-3">
          <div class="d-flex justify-content-between align-items-center">
            <span>Đơn hàng ({{ products.length }} sản phẩm)</span>
            <router-link class="px-3 py-2 rounded bg-white border text-dark" :to="{name: 'Cart'}">Sửa</router-link>
          </div>
          <div>
            <hr />
            <div v-for="product in products" :key="product.id" style="font-size: .8rem">
              <div class="d-md-flex justify-content-between align-items-center">
                <div>
                  <strong>{{ product.quantity }} x</strong>
                  <router-link :to="{name: 'Product', params: {id: product.master_product_id || product.id}, query: product.color ? {color: product.color.id} : {}}">
                    {{ product.name }}
                    <template v-if="product.color"> - {{ product.color.name }}</template>
                    <template v-if="product.size"> - {{ product.size.name }}</template>
                  </router-link>
                </div>
                <div>{{ totalPricePerItem(product) | priceFormat }}</div>
              </div>
              <hr />
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <strong>Thành tiền</strong>
            <p class="text-danger mb-0 font-size-base">{{ totalPrice | priceFormat }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { priceFormat } from '@/filters';
import { mapState, mapMutations } from 'vuex';
import orderService from '@/shared/services/order.service';
import MatButton from '@/components/shared/material/MatButton';

export default {
  components: {
    MatButton
  },
  filters: {
    priceFormat
  },
  data() {
    return {
      loading: false
    };
  },
  computed: {
    ...mapState('cart', [
      'products',
      'deliveryDetail',
      'cities',
      'districts',
      'wards'
    ]),
    city() {
      const city = this.cities.find(item => item.id === this.deliveryDetail.receiver_city_id);

      return city;
    },
    district() {
      const district = this.districts.find(item => item.id === this.deliveryDetail.receiver_district_id);

      return district;
    },
    ward() {
      const ward = this.wards.find(item => item.id === this.deliveryDetail.receiver_ward_id);

      return ward;
    },
    fullAddress() {
      if (this.ward && this.district && this.city) {
        return `${this.deliveryDetail.receiver_address}, ${this.ward.name}, ${this.district.name}, ${this.city.name}`;
      }

      return '';
    },
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
    ...mapMutations('cart', [
      'clear'
    ]),
    onSubmit() {
      this.loading = true;
      const body = JSON.parse(JSON.stringify(this.deliveryDetail));
      body.total_price = this.totalPrice;
      body.products = [];

      for (const product of this.products) {
        body.products.push({
          id: product.id,
          quantity: product.quantity,
          sale_price: product.sale_price
        });
      }

      orderService.store(body)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.clear();
            this.$router.push({name: 'CheckoutSuccess', query: {code: response.data.code}});
          }

          this.loading = false;
        });
    }
  }
};
</script>

<style lang="scss" scoped>
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.payment {
  font-size: $font-size-sm;

  a:hover {
    text-decoration: none;
  }
}
</style>
