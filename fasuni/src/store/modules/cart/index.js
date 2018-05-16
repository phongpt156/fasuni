import mutations from './mutations';

const state = {
  products: [],
  isOpenCartDialog: false
};

export default {
  namespaced: true,
  state,
  mutations
};
