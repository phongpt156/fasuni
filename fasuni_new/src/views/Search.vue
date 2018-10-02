<template>
  <div class="search-page">
    <main-body></main-body>
  </div>
</template>

<script>
import MainBody from '@/components/category/main-body/MainBody';
import { mapMutations, mapState } from 'vuex';
import { Pagination } from '@/shared/classes';
import productService from '@/shared/services/product.service';

export default {
  created() {
    if (!this.$route.params.type) {
      this.$router.push({name: 'Search', params: {type: 'newest'}});
    }
  },
  components: {
    MainBody
  },
  data() {
    return {
      pagination: new Pagination()
    };
  },
  computed: {
    ...mapState('products', [
      'products',
      'loading',
      'filterButton'
    ]),
    name() {
      return this.$route.params.name;
    },
    type() {
      return this.$route.params.type;
    },
    colors() {
      return this.$route.query.colors;
    },
    sizes() {
      return this.$route.query.sizes;
    },
    colorsString() {
      return this.filterButton.children.colors.selectedList.join(',');
    },
    sizesString() {
      return this.filterButton.children.sizes.selectedList.join(',');
    }
  },
  watch: {
    colorsString(newValue) {
      this.$router.push({name: this.$route.name, params: {id: this.id, type: this.type}, query: { colors: newValue, sizes: this.sizes }});
    },
    sizesString(newValue) {
      this.$router.push({name: this.$route.name, params: {id: this.id, type: this.type}, query: { colors: this.colors, sizes: newValue }});
    },
    colors(newValue) {
      this.setEmptyProducts();
      this.getProducts(1);
    },
    sizes(newValue) {
      this.setEmptyProducts();
      this.getProducts(1);
    },
    type(newValue) {
      this.setEmptyProducts();
      this.getProducts(1);
    },
    name(newValue) {
      this.setEmptyProducts();
      this.getProducts(1);
    }
  },
  methods: {
    ...mapMutations('products', [
      'setLoading',
      'setEmptyProducts',
      'setProducts'
    ]),
    getProducts(page) {
      if (!this.loading) {
        this.setLoading(true);

        productService.searchByName({
          name: this.name,
          type: this.type,
          colors: this.colors,
          sizes: this.sizes
        }, page)
          .then(response => {
            if (response && response.status === 200 && response.data) {
              this.setProducts(response.data.data);

              if (!response.data.next_page_url) {
                document.removeEventListener('scroll', this.onScroll);
              }

              this.pagination.total = response.data.total;
              this.pagination.current = response.data.current_page;
              this.pagination.perPage = response.data.per_page;
              this.setLoading(false);
            }
          });
      }
    },
    onScroll() {
      const footerHeight = document.querySelector('.footer').offsetHeight;

      if (document.documentElement.scrollTop + window.innerHeight >= document.documentElement.scrollHeight - footerHeight) {
        this.getProducts(this.pagination.current + 1);
      }
    }
  },
  mounted() {
    this.getProducts(1);
    document.addEventListener('scroll', this.onScroll, {
      passive: true
    });
  },
  destroyed() {
    document.removeEventListener('scroll', this.onScroll);
    this.setEmptyProducts();
  }
};
</script>

<style lang="scss">
.search-page {
  min-height: calc(100vh - 322px);
}
</style>
