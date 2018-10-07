import mutations from './mutations';

const state = {
  products: [],
  deliveryDetail: {
    receiver_name: '',
    receiver_phone: '',
    receiver_city_id: '',
    receiver_district_id: '',
    receiver_ward_id: '',
    receiver_address: '',
    note: '',
  },
  isOpenCartDialog: false,
  cities: [],
  districts: [],
  wards: [],
};

export default {
  namespaced: true,
  state,
  mutations,
};
