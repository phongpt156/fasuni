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
            <a class="dropdown-item" @click="selectedType = 'newest'" :class="{'active': type === 'newest'}">Mới nhất</a>
            <a class="dropdown-item" @click="selectedType = 'best-seller'" :class="{'active': type === 'best-seller'}">Mua nhiều nhất</a>
            <a class="dropdown-item" @click="selectedType = 'most-like'" :class="{'active': type === 'most-like'}">Thích nhiều nhất</a>
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
            <div class="mt-3">
              <multi-select
                :options="child.children"
                :placeholder="child.name"
                label="name"
                v-model="child.selectedList"
                distinct="id"
                track-by="id">
              </multi-select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-4">
      <product-list :selectedType="selectedType" :selectedColors="filterButton.children.colors.selectedList" :selectedSizes="filterButton.children.sizes.selectedList"></product-list>
    </div>
    <hr class="bg-dark m-0" />
  </div>
</template>

<script>
import ProductList from './product-list/ProductList';
import attributeValueService from '@/shared/services/attribute-value.service';
import MultiSelect from '@/components/shared/multi-select/MultiSelect';

export default {
  name: 'Body',
  components: {
    ProductList,
    MultiSelect
  },
  data() {
    return {
      selectedType: '',
      filterButton: {
        name: 'Bộ lọc',
        children: {
          colors: {
            name: 'Màu sắc',
            children: [],
            selectedList: []
          },
          sizes: {
            name: 'Size',
            children: [],
            selectedList: []
          }
        }
      },
      isOpenFilter: false
    };
  },
  computed: {
    type() {
      return this.$route.params.type;
    }
  },
  methods: {
    toggleIsOpenFilter() {
      this.isOpenFilter = !this.isOpenFilter;
    },
    getColors() {
      return new Promise(resolve => {
        attributeValueService.getColors()
          .then(response => {
            if (response && response.status === 200 && response.data) {
              this.filterButton.children.colors.children = response.data;
            }
            resolve();
          });
      });
    },
    getSizes() {
      return new Promise(resolve => {
        attributeValueService.getSizes()
          .then(response => {
            if (response && response.status === 200 && response.data) {
              this.filterButton.children.sizes.children = response.data;
            }
            resolve();
          });
      });
    },
    parseColorsFromUrl() {
      const colors = this.$route.query.colors;

      if (colors) {
        let ids = colors.split(',');
        this.filterButton.children.colors.children.forEach(color => {
          if (ids.indexOf(String(color.id)) !== -1) {
            this.filterButton.children.colors.selectedList.push(color.id);
          }
        });
      }
    },
    parseSizesFromUrl() {
      const sizes = this.$route.query.sizes;

      if (sizes) {
        let ids = sizes.split(',');
        this.filterButton.children.sizes.children.forEach(size => {
          if (ids.indexOf(String(size.id)) !== -1) {
            this.filterButton.children.sizes.selectedList.push(size.id);
          }
        });
      }
    }
  },
  async mounted() {
    await Promise.all([this.getColors(), this.getSizes()]);
    this.parseColorsFromUrl();
    this.parseSizesFromUrl();
    this.selectedType = this.$route.params.type;
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
    .dropdown-item {
      &.active {
        color: #fff;
        background-color: #545b62;

        &:hover {
          color: #fff;
        }
      }

      &:hover {
        color: #fff !important;
        background-color: #545b62;
      }
    }
  }
</style>
