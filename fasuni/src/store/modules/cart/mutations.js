export default {
  add(state, product) {
    state.products.push(product);
  },
  remove(state, index) {
    state.products.splice(index, 1);
  },
  setProducts(state, products) {
    state.products = products;
  },
  syncCartFromStorage(state) {

  }
};
