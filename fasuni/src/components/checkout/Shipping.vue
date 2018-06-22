<template>
  <div class="d-flex justify-content-center my-5">
    <mat-form
      ref="checkoutForm"
      :model="deliveryDetail"
      :rules="checkoutRules"
      @submit="onSubmit"
      :inline="true">
      <div class="form-item">
        <mat-input
          label="Họ tên"
          placeholder="Nhập họ tên"
          :required="true"
          type="text"
          :value="deliveryDetail.receiver_name"
          @input="doUpdateDeliveryDetailInfo('receiver_name', $event)"
          prop="receiver_name">
        </mat-input>
      </div>
      <div class="form-item">
        <mat-input
          label="Số điện thoại"
          placeholder="Nhập số điện thoại"
          :required="true"
          type="text"
          :value="deliveryDetail.receiver_phone"
          @input="doUpdateDeliveryDetailInfo('receiver_phone', $event)"
          prop="receiver_phone">
        </mat-input>
      </div>
      <div class="form-item">
        <mat-select
          label="Tỉnh/Thành phố"
          placeholder="Chọn Tỉnh/Thành phố"
          type="text"
          :value="deliveryDetail.receiver_city_id"
          @input="changeCity"
          :required="true"
          prop="receiver_city_id">
          <option
            v-for="city in cities"
            :value="city.id"
            :key="city.id"
            slot="option"
            class="text-dark">
            {{ city.name }}
          </option>
        </mat-select>
      </div>
      <div class="form-item">
        <mat-select
          label="Quận/Huyện"
          placeholder="Chọn Quận/Huyện"
          type="text"
          :value="deliveryDetail.receiver_district_id"
          @input="changeDistrict"
          :required="true"
          prop="receiver_district_id">
          <option
            v-for="district in districts"
            :value="district.id"
            :key="district.id"
            slot="option"
            class="text-dark">
            {{ district.name }}
          </option>
        </mat-select>
      </div>
      <div class="form-item">
        <mat-select
          label="Phường/Xã"
          placeholder="Chọn Phường/Xã"
          type="text"
          :value="deliveryDetail.receiver_ward_id"
          @input="changeWard"
          prop="receiver_ward_id">
          <option
            v-for="ward in wards"
            :value="ward.id"
            :key="ward.id"
            slot="option"
            class="text-dark">
            {{ ward.name }}
          </option>
        </mat-select>
      </div>
      <div class="form-item">
        <mat-textarea
          label="Địa chỉ"
          placeholder="Nhập địa chỉ"
          type="text"
          :value="deliveryDetail.receiver_address"
          @input="doUpdateDeliveryDetailInfo('receiver_address', $event)"
          :required="true"
          prop="receiver_address">
        </mat-textarea>
      </div>
      <div class="form-item">
        <mat-textarea
          label="Ghi chú"
          placeholder="Nhập ghi chú cho đơn hàng"
          type="text"
          :value="deliveryDetail.note"
          @input="doUpdateDeliveryDetailInfo('note', $event)">
        </mat-textarea>
      </div>
      <div class="text-center mt-5">
        <mat-button type="submit" class="btn btn-success" placeholder="Giao hàng đến địa chỉ này" :loading="loading"></mat-button>
      </div>
    </mat-form>
  </div>
</template>

<script>
import { ERROR_MESSAGE, PATTERN } from '@/shared/constants';
import { mapState, mapMutations } from 'vuex';
import MatInput from '@/components/shared/material/MatInput';
import MatForm from '@/components/shared/material/MatForm';
import MatSelect from '@/components/shared/material/MatSelect';
import MatTextarea from '@/components/shared/material/MatTextarea';
import MatButton from '@/components/shared/material/MatButton';
// import userService from '@/shared/services/user.service';
import cityService from '@/shared/services/city.service';
import districtService from '@/shared/services/district.service';
import userDeliveryInfoService from '@/shared/services/user-delivery-info.service';

export default {
  components: {
    MatInput,
    MatForm,
    MatSelect,
    MatTextarea,
    MatButton
  },
  data() {
    return {
      checkoutRules: {
        receiver_name: [
          { required: true, message: ERROR_MESSAGE.name.required }
        ],
        receiver_phone: [
          { required: true, message: ERROR_MESSAGE.phoneNumber.required },
          { validator: PATTERN.phoneNumber, message: ERROR_MESSAGE.phoneNumber.format }
        ],
        receiver_city_id: [
          { required: true, message: ERROR_MESSAGE.city.required }
        ],
        receiver_district_id: [
          { required: true, message: ERROR_MESSAGE.district.required }
        ],
        receiver_address: [
          { required: true, message: ERROR_MESSAGE.address.required }
        ]
      },
      cities: [],
      districts: [],
      wards: [],
      loading: false
    };
  },
  computed: {
    ...mapState([
      'user'
    ]),
    ...mapState('cart', [
      'products',
      'deliveryDetail'
    ])
  },
  watch: {
    user(newValue) {
      if (newValue) {
        this.getInfoOfUser();
      }
    }
  },
  methods: {
    ...mapMutations('cart', [
      'updateDeliveryDetailInfo',
      'setDeliveryDetail'
    ]),
    getInfoOfUser() {
      userDeliveryInfoService.getInfoOfUser()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.fillCheckoutForm(response.data);
          }
        });
    },
    async fillCheckoutForm(data) {
      const body = {};

      if (data.id) {
        await Promise.all([this.getDistrictsOfCity(data.district.city_id), this.getWardsOfDistrict(data.receiver_district_id)]);

        body.receiver_name = data.receiver_name;
        body.receiver_phone = data.receiver_phone;
        body.receiver_city_id = data.district.city_id;
        body.receiver_district_id = data.receiver_district_id;
        body.receiver_ward_id = data.receiver_ward_id;
        body.receiver_address = data.receiver_address;
      } else {
        body.receiver_name = this.user.name || this.user.facebook_name || this.user.google_name || `${this.user.first_name} ${this.user.last_name}`;
        body.receiver_phone = this.user.phone_number;
        body.receiver_city_id = this.user.living_city_id;

        this.getDistrictsOfCity(this.user.living_city_id);
      }

      this.setDeliveryDetail(body);
    },
    getCities() {
      cityService.getAll()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.cities = response.data;
          }
        });
    },
    getDistrictsOfCity(cityId) {
      return new Promise(resolve => {
        this.districts = [];

        cityService.getDistricts(cityId)
          .then(response => {
            if (response && response.status === 200 && response.data) {
              this.districts = response.data;
              resolve();
            }
          });
      });
    },
    getWardsOfDistrict(districtId) {
      return new Promise(resolve => {
        this.wards = [];

        districtService.getWards(districtId)
          .then(response => {
            if (response && response.status === 200 && response.data) {
              this.wards = response.data;
              resolve();
            }
          });
      });
    },
    onSubmit() {
      this.$refs.checkoutForm.validate();

      if (this.$refs.checkoutForm.isValid) {
        this.$emit('submit');
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

        userDeliveryInfoService.store(body)
          .then(response => {
            if (response && response.status === 200 && response.data) {
              this.$emit('submit');
            }
            this.loading = false;
          });
      }
    },
    doUpdateDeliveryDetailInfo(field, value) {
      this.updateDeliveryDetailInfo({
        field,
        value
      });
    },
    changeCity(value) {
      this.getDistrictsOfCity(value);
      this.doUpdateDeliveryDetailInfo('receiver_district_id', '');
      this.doUpdateDeliveryDetailInfo('receiver_city_id', value);
    },
    changeDistrict(value) {
      value = Number(value);
      console.log(value);

      this.getWardsOfDistrict(value);
      this.doUpdateDeliveryDetailInfo('receiver_ward_id', '');
      this.doUpdateDeliveryDetailInfo('receiver_district_id', value);
    },
    changeWard(value) {
      value = Number(value);

      this.doUpdateDeliveryDetailInfo('receiver_ward_id', value);
      console.log(this.deliveryDetail);
    }
  },
  mounted() {
    if (this.user) {
      this.getInfoOfUser();
    }
    this.getCities();
  }
};
</script>

<style>

</style>
