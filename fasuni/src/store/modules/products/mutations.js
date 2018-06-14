export default {
  setLoading(state, value) {
    state.loading = value;
  },
  setEmptyProducts(state) {
    state.products = [];
  },
  setProducts(state, products) {
    if (state.products.length) {
      state.products = state.products.concat(products);
    } else if (products) {
      state.products = products;
    } else {
      state.products = [];
    }
  },
  setFilterColors(state, colors) {
    state.filterButton.children.colors.children = colors;
  },
  setFilterSizes(state, sizes) {
    state.filterButton.children.sizes.children = sizes;
  },
  pushSelectedColors(state, color) {
    state.filterButton.children.colors.selectedList.push(color);
  },
  pushSelectedSizes(state, size) {
    state.filterButton.children.sizes.selectedList.push(size);
  },
  pushSelectedList(state, payload) {
    payload.selectedList.push(payload.item);
  },
  removeItemFromSelectedList(state, payload) {
    payload.selectedList.splice(payload.index, 1);
  },
  toggleLiked(state, product) {
    product.liked = !product.liked;
  }
};
