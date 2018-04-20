<template>
  <div class="sidenav-overlay p-4">
    <div class="category-list">
      <div v-for="category in categories" :key="category.id" class="category-item py-1">
        <a>
          {{ category.name }}
        </a>
      </div>
      <div class="category-item py-1">
        <a>Studio's</a>
      </div>
    </div>
    <search-form class="my-2"></search-form>
  </div>
</template>

<script>
import SearchForm from './../search-form/SearchForm';

export default {
  props: {
    categories: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  components: {
    SearchForm
  },
  data() {
    return {

    };
  }
};
</script>

<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';
  @import '~bootstrap/scss/bootstrap-grid';

  .sidenav-overlay {
    z-index: 9999;
    top: 0;
    right: 0;
    position:fixed;
    height: 100%;
    font-size: $font-size-base;
    color: #818181;
    background-color: #111;

    .category-list {
      .category-item {
        &:hover {
          color: $white;
        }
      }
    }
  }

  @include media-breakpoint-up(lg) {
    .sidenav-overlay {
      display: none;
    }
  }
</style>
