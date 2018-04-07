<template>
  <div class="main-body">
    <div class="px-3">
      <div class="d-flex flex-wrap">
        <div class="mt-3">
          <button
            class="btn btn-secondary dropdown-toggle button d-flex justify-content-between align-items-center mr-2"
            type="button"
            id="dropdownSortMenuButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
            Sắp xếp theo
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownSortMenuButton">
            <a class="dropdown-item">Mới nhất</a>
            <a class="dropdown-item">Mua nhiều nhất</a>
            <a class="dropdown-item">Thích nhiều nhất</a>
          </div>
        </div>
        <button
          class="btn btn-secondary button d-flex justify-content-between align-items-center mr-2 mt-3 filter-button"
          type="button"
          aria-haspopup="true"
          aria-expanded="false"
          @click="toggleIsOpenFilter">
          {{ filterButton.name }}
        </button>
        <div class="d-flex flex-wrap" v-if="isOpenFilter">
          <div v-for="child in filterButton.children" :key="child.name" class="mr-2">
            <button
              class="btn btn-secondary dropdown-toggle button d-flex justify-content-between align-items-center mt-3"
              type="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false">
              {{ child.name }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-4">
      <product-list></product-list>
    </div>
    <hr class="bg-dark m-0" />
  </div>
</template>

<script>
import ProductList from './product-list/ProductList';

export default {
  name: 'Body',
  components: {
    ProductList
  },
  data() {
    return {
      filterButton: {
        name: 'Bộ lọc',
        children: [
          {
            name: 'Màu sắc'
          },
          {
            name: 'Kiểu dáng'
          },
          {
            name: 'Kích cỡ'
          },
          {
            name: 'Size'
          },
          {
            name: 'Phong cách'
          }
        ]
      },
      isOpenFilter: false
    };
  },
  methods: {
    toggleIsOpenFilter() {
      this.isOpenFilter = !this.isOpenFilter;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';

  .main-body {
    .button {
      width: 173px;
      font-size: $font-size-sm;
      color: $dark;
      background-color: #dddddd;
    }
    .filter-button {
      &::after {
        width: 0;
        vertical-align: 0.255em;
        margin-left: 0.255em;
        height: 0;
        display: inline-block;
        content: "";
        border-top: 0.3em solid transparent;
        border-right: 0;
        border-left: 0.3em solid;
        border-bottom: 0.3em solid transparent;
      }
    }
  }
</style>
