<template>
  <div class="main-body">
    <div class="p-3">
      <div class="d-flex">
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
        <button
          class="btn btn-secondary button d-flex justify-content-between align-items-center mr-2"
          type="button"
          aria-haspopup="true"
          aria-expanded="false">
          {{ filterButton.name }}
        </button>
        <font-awesome-icon :icon="caretRightIcon"></font-awesome-icon>
        <div class="d-flex">
          <div v-for="child in filterButton.children" :key="child.name" class="mr-2">
            <button
              class="btn btn-secondary dropdown-toggle button d-flex justify-content-between align-items-center"
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
  </div>
</template>

<script>
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import faCaretRight from '@fortawesome/fontawesome-free-solid/faCaretRight';

export default {
  name: 'Body',
  components: {
    FontAwesomeIcon
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
      }
    };
  },
  computed: {
    caretRightIcon() {
      return faCaretRight;
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
  }
</style>
