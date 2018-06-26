<template>
  <div class="container order-history py-5">
    <p class="mb-0">Đơn hàng của tôi</p>
    <div class="table-responsive mt-3">
      <table class="table bg-white font-size-sm">
        <thead>
          <tr>
            <th scope="col">Mã đơn hàng</th>
            <th scope="col">Ngày mua</th>
            <th scope="col">Sản phẩm</th>
            <th scope="col">Tổng tiền</th>
            <th scope="col" class="text-right">Trạng thái đơn hàng</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders" :key="order.id">
            <td>
              <router-link :to="{name: 'ViewOrder', query: {code: order.code}}">{{ order.code }}</router-link>
            </td>
            <td>
              {{ order.created_at | getLocalDatefromUtcDate }}
            </td>
            <td>
              <span v-for="(orderDetail, index) in order.order_details" :key="index">
                {{ orderDetail.quantity }}x {{ orderDetail.product.name }} -
                <template v-if="orderDetail.product.color">{{ orderDetail.product.color.name }}</template> -
                <template v-if="orderDetail.product.size">{{ orderDetail.product.size.name }}</template>
                <template v-if="index !== totalOrderDetail(order) - 1">, </template>
              </span>
            </td>
            <td>
              {{ totalOrderPrice(order) | priceFormat }}
            </td>
            <td class="text-right">{{ orderStatus(order) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import orderService from '@/shared/services/order.service';
import { getLocalDatefromUtcDate, priceFormat } from '@/filters';

export default {
  filters: {
    getLocalDatefromUtcDate,
    priceFormat
  },
  data() {
    return {
      orders: []
    };
  },
  computed: {
    totalOrderPrice() {
      return order => {
        let total = 0;

        for (const orderDetail of order.order_details) {
          total += orderDetail.price * orderDetail.quantity;
        }

        return total;
      };
    },
    orderStatus() {
      return order => {
        if (order.status_id === 1) {
          return 'Đặt hàng thành công';
        } else if (order.status_id === 4) {
          return 'Đã hủy';
        }

        return '';
      };
    },
    totalOrderDetail() {
      return order => order.order_details.length;
    }
  },
  methods: {
    getOrderHistoriesOfUser() {
      orderService.getOrderHistoriesOfUser()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.orders = response.data;
            console.log(response.data);
          }
        });
    }
  },
  created() {
    this.getOrderHistoriesOfUser();
  }
};
</script>

<style lang="scss">
.order-history {
  min-height: calc(100vh - 322px);
}

</style>
