<template>
  <div class="view-order container py-5">
    <div class="w-100 d-flex justify-content-center" v-if="loading">
      <spinner class="mt-3" :loading="loading"></spinner>
    </div>
    <template v-else>
      <div class="d-md-flex align-items-center justify-content-between">
        <h6>Chi tiết đơn hàng #{{ code }} - <strong>{{ status }}</strong></h6>
        <p class="mb-0">Ngày đặt hàng: {{ order.created_at | getLocalDatefromUtcDate }}</p>
      </div>
      <div class="row mt-4">
        <div class="col-12 delivery-detail font-size-sm" v-if="order.delivery_detail">
          <p class="mb-2">Địa chỉ người nhận</p>
          <div class="bg-white px-2 py-3">
            <p class="mb-2"><b>{{ order.delivery_detail.receiver_name }}</b></p>
            <p class="mb-0">Địa chỉ: {{ fullAddress }}</p>
            <p class="mb-0">Điện thoại: {{ order.delivery_detail.receiver_phone }}</p>
          </div>
        </div>
        <div class="col-12 mt-4">
          <div class="bg-white">
            <div class="table-responsive">
              <table class="w-100 px-2 text-center table font-size-sm">
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
                  <tr v-for="(orderDetail, index) in order.order_details" :key="index" class="bg-white">
                    <td style="width: 150px">
                      <div class="image-wrapper image-standard">
                        <img :src="image(orderDetail.product).original" :alt="orderDetail.product.name" class="w-100 h-100" v-if="image(orderDetail.product)" />
                      </div>
                    </td>
                    <td>{{ orderDetail.product.name }}</td>
                    <td>
                      <template v-if="orderDetail.product.color">
                        <div class="color mx-auto" :style="{backgroundColor: orderDetail.product.color.value}"></div>
                        <p class="mb-0 mt-2">{{ orderDetail.product.color.name }}</p>
                      </template>
                    </td>
                    <td>
                      <template v-if="orderDetail.product.size">
                        {{ orderDetail.product.size.name }}
                      </template>
                      <template v-else>
                        Free Size
                      </template>
                    </td>
                    <td>
                      <div class="number-input d-inline-block">
                        {{ orderDetail.quantity }}
                      </div>
                    </td>
                    <td>{{ totalPricePerItem(orderDetail) | priceFormat }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <hr />
            <div class="d-flex flex-column align-items-end pr-3 pb-3">
              <p>Tổng cộng: <span class="text-danger">{{ totalPrice | priceFormat }}</span></p>
              <button class="btn btn-warning" v-if="order.status_id !== 4" @click="openConfirmdeleteOrderDialog">Hủy đơn hàng</button>
            </div>
          </div>
        </div>
      </div>
      <confirm-delete-order-dialog :isOpenConfirmDeleteOrderDialog.sync="isOpenConfirmDeleteOrderDialog" class="w-50" :code="order.code" @delete="deleteOrder" :loading="deletingOrder"></confirm-delete-order-dialog>
      <success-delete-order-dialog :isOpenSuccessDeleteOrderDialog.sync="isOpenSuccessDeleteOrderDialog" class="w-50"></success-delete-order-dialog>
    </template>
  </div>
</template>

<script>
import orderService from '@/shared/services/order.service';
import { getLocalDatefromUtcDate, priceFormat } from '@/filters';
import Spinner from '@/components/shared/spinner/Spinner';
import ConfirmDeleteOrderDialog from '@/components/order/ConfirmDeleteOrderDialog';
import SuccessDeleteOrderDialog from '@/components/order/SuccessDeleteOrderDialog';

export default {
  filters: {
    getLocalDatefromUtcDate,
    priceFormat
  },
  components: {
    Spinner,
    ConfirmDeleteOrderDialog,
    SuccessDeleteOrderDialog
  },
  data() {
    return {
      order: {},
      loading: true,
      isOpenConfirmDeleteOrderDialog: false,
      isOpenSuccessDeleteOrderDialog: false,
      deletingOrder: false
    };
  },
  computed: {
    code() {
      return this.$route.query.code;
    },
    status() {
      if (this.order.status_id === 1) {
        return 'Đặt hàng thành công';
      } else if (this.order.status_id === 4) {
        return 'Đã hủy';
      }

      return '';
    },
    fullAddress() {
      if (this.order.delivery_detail) {
        return `${this.order.delivery_detail.receiver_address}, ${this.order.delivery_detail.ward.name}, ${this.order.delivery_detail.district.name}, ${this.order.delivery_detail.district.city.name}`;
      }

      return '';
    },
    totalPricePerItem() {
      return orderDetail => orderDetail.price * orderDetail.quantity;
    },
    totalPrice() {
      let total = 0;

      if (this.order.order_details) {
        this.order.order_details.forEach(orderDetail => {
          total += this.totalPricePerItem(orderDetail);
        });
      }

      return total;
    },
    image() {
      return product => {
        if (product.images.length) {
          return product.images[0];
        }

        if (product.master_product_id) {
          if (product.master_product.images.length) {
            if (product.color) {
              if (product.master_product.color && product.color.id === product.master_product.color.id) {
                return product.master_product.images[0];
              }
            }

            return product.master_product.images[0];
          }
          for (const subProduct of product.master_product.sub_products) {
            if (subProduct.images.length) {
              if (product.color) {
                if (subProduct.color && product.color.id === subProduct.color.id) {
                  return subProduct.images[0];
                }
              }

              return subProduct.images[0];
            }
          }
        }

        for (const subProduct of product.sub_products) {
          if (subProduct.images.length) {
            if (product.color) {
              if (subProduct.color && product.color.id === subProduct.color.id) {
                return subProduct.images[0];
              }
            }

            return subProduct.images[0];
          }
        }
      };
    }
  },
  methods: {
    getOrder() {
      orderService.getOne(this.code)
        .then(response => {
          if (response && response.status === 200 && response.data && response.data.id) {
            this.order = response.data;
          } else {
            this.$router.push({name: 'OrderHistory'});
          }

          this.loading = false;
        });
    },
    openConfirmdeleteOrderDialog() {
      this.isOpenConfirmDeleteOrderDialog = true;
    },
    deleteOrder() {
      this.deletingOrder = true;

      orderService.delete(this.order.id)
        .then(response => {
          this.deletingOrder = false;
          this.isOpenConfirmDeleteOrderDialog = false;
          this.isOpenSuccessDeleteOrderDialog = true;
          this.order.status_id = 4;
        });
    }
  },
  created() {
    this.getOrder();
  }
};
</script>

<style lang="scss">
.view-order {
  min-height: calc(100vh - 322px);

  .color {
    width: 25px;
    height: 25px;
    border: 1px solid #000;
  }
}
</style>
