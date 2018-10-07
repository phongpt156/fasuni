export default {
  add(state, payload) {
    const existProduct = state.products.find(product => product.id === payload.product.id);

    if (existProduct) {
      const index = state.products.indexOf(existProduct);
      state.products[index].quantity++;
    } else {
      const product = JSON.parse(JSON.stringify(payload.product));
      if (!product.images || !product.images.length) {
        product.images = payload.images;
      }
      product.quantity = 1;
      state.products.unshift(product);
    }
    this.commit('cart/saveCartToStorage');
    this.commit('cart/setIsOpenCartDialog', true);
  },
  remove(state, index) {
    state.products.splice(index, 1);
    this.commit('cart/saveCartToStorage');
  },
  clear(state) {
    state.products = [];
    localStorage.removeItem('cart');
  },
  setProducts(state, products) {
    state.products = products;
  },
  getCartFromStorage(state) {
    const products = localStorage.getItem('cart');
    if (products) {
      state.products = JSON.parse(products);
    } else {
      state.products = [];
    }
  },
  saveCartToStorage(state) {
    localStorage.setItem('cart', JSON.stringify(state.products));
  },
  setIsOpenCartDialog(state, value) {
    state.isOpenCartDialog = value;
  },
  updateQuantity(state, {product, quantity}) {
    if (quantity >= 0 && quantity <= 10000) {
      product.quantity = quantity;
      this.commit('cart/saveCartToStorage');
    }
  },
  setDeliveryDetail(state, data) {
    Object.assign(state.deliveryDetail, data);
  },
  updateDeliveryDetailInfo(state, payload) {
    state.deliveryDetail[payload.field] = payload.value;
  },
  selectCity(state, value) {
    state.selectedCity = value;
  },
  selectDistrict(state, value) {
    state.selectedDistrict = value;
  },
  selectWard(state, value) {
    state.selectedWard = value;
  },
  setCities(state, cities) {
    state.cities = cities;
  },
  setDistricts(state, districts) {
    state.districts = districts;
  },
  setWards(state, wards) {
    state.wards = wards;
  },
};
