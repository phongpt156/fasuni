import mutations from './mutations';

const state = {
  loading: false,
  products: [],
  filterButton: {
    name: 'Bộ lọc',
    children: {
      colors: {
        name: 'Màu sắc',
        children: [],
        selectedList: [],
      },
      sizes: {
        name: 'Size',
        children: [],
        selectedList: [],
      },
    },
  },
};

export default {
  namespaced: true,
  state,
  mutations,
};
