<template>
  <div class="d-flex justify-content-center my-5">
    <mat-form
      ref="checkoutForm"
      :model="checkoutForm"
      :rules="checkoutRules"
      @submit="onSubmit"
      :inline="true">
      <div class="form-item">
        <mat-input
          label="Họ tên"
          placeholder="Nhập họ tên"
          :required="true"
          type="text"
          v-model="checkoutForm.receiver_name"
          prop="receiver_name">
        </mat-input>
      </div>
      <div class="form-item">
        <mat-input
          label="Số điện thoại"
          placeholder="Nhập số điện thoại"
          :required="true"
          type="text"
          v-model="checkoutForm.receiver_phone"
          prop="receiver_phone">
        </mat-input>
      </div>
      <div class="form-item">
        <mat-select
          label="Tỉnh/Thành phố"
          placeholder="Chọn Tỉnh/Thành phố"
          type="text"
          v-model.number="checkoutForm.receiver_city_id"
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
          v-model.number="checkoutForm.receiver_district_id"
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
          v-model.number="checkoutForm.receiver_ward_id"
          :required="true"
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
          v-model="checkoutForm.receiver_address"
          :required="true"
          prop="receiver_address">
        </mat-textarea>
      </div>
      <div class="form-item">
        <mat-textarea
          label="Ghi chú"
          placeholder="Nhập ghi chú cho đơn hàng"
          type="text"
          v-model="checkoutForm.note">
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
import { mapState } from 'vuex';
import MatInput from '@/components/shared/material/MatInput';
import MatForm from '@/components/shared/material/MatForm';
import MatSelect from '@/components/shared/material/MatSelect';
import MatTextarea from '@/components/shared/material/MatTextarea';
import MatButton from '@/components/shared/material/MatButton';
import userService from '@/shared/services/user.service';
import cityService from '@/shared/services/city.service';
import districtService from '@/shared/services/district.service';
import orderService from '@/shared/services/order.service';

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
      checkoutForm: {
        receiver_name: '',
        receiver_phone: '',
        receiver_city_id: '',
        receiver_district_id: '',
        receiver_ward_id: '',
        receiver_address: '',
        note: '',
        products: []
      },
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
        receiver_ward_id: [
          { required: true, message: ERROR_MESSAGE.ward.required }
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
      'products'
    ]),
    receiverCityId() {
      return this.checkoutForm.receiver_city_id;
    },
    receiverDistrictId() {
      return this.checkoutForm.receiver_district_id;
    },
    totalPrice() {
      let total = 0;
      this.products.forEach(product => {
        total += product.sale_price * product.quantity;
      });

      return total;
    }
  },
  watch: {
    user(newValue) {
      if (newValue) {
        this.getDeliveryInfo();
      }
    },
    receiverCityId(newValue) {
      this.checkoutForm.receiver_district_id = '';
      this.checkoutForm.receiver_ward_id = '';
      this.getDistrictsOfCity(newValue);
    },
    receiverDistrictId(newValue) {
      this.checkoutForm.receiver_ward_id = '';
      this.getWardsOfDistrict(newValue);
    },
    step(newValue, oldValue) {
      this.$refs.formWizard.changeTab(oldValue, newValue);
    }
  },
  methods: {
    getDeliveryInfo() {
      userService.getDeliveryInfo()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.fillCheckoutForm(response.data);
          }
        });
    },
    fillCheckoutForm(data) {
      this.checkoutForm.receiver_name = data.name || data.facebook_name || data.google_name || `${data.first_name} ${data.last_name}`;
      this.checkoutForm.receiver_phone = data.phone_number;

      this.checkoutForm.city_id = data.city_id;
      this.checkoutForm.district_id = data.district_id;
      this.checkoutForm.ward_id = data.ward_id;
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
      this.districts = [];

      cityService.getDistricts(cityId)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.districts = response.data;
          }
        });
    },
    getWardsOfDistrict(districtId) {
      this.wards = [];

      districtService.getWards(districtId)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.wards = response.data;
          }
        });
    },
    onSubmit() {
      this.$refs.checkoutForm.validate();

      if (this.$refs.checkoutForm.isValid) {
        this.$emit('submit');
        // this.loading = true;
        // this.checkoutForm.products = [];

        // for (const product of this.products) {
        //   this.checkoutForm.products.push({
        //     id: product.id,
        //     quantity: product.quantity,
        //     sale_price: product.sale_price
        //   });
        // }

        // const body = JSON.parse(JSON.stringify(this.checkoutForm));
        // body.total_price = this.totalPrice;

        // orderService.store(body)
        //   .then(response => {
        //     if (response && response.status === 200 && response.data) {
        //       this.$emit('submit');
        //     }
        //     this.loading = false;
        //   });
      }
    }
  },
  mounted() {
    if (this.user) {
      this.getDeliveryInfo();
    }
    this.getCities();
  }
};
</script>

<style>

</style>
