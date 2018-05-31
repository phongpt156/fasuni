<template>
  <div class="product-list">
    <div class="row mx-2 mt-2">
      <div v-for="product in products" :key="product.id" class="col-xl-3 col-sm-6 px-2 my-2" v-if="products.length">
        <product-card :product="product"></product-card>
      </div>
      <div class="w-100 d-flex justify-content-center">
        <spinner class="mt-3" :loading="loading"></spinner>
      </div>
    </div>
  </div>
</template>

<script>
import ProductCard from './product-card/ProductCard';
import productService from '@/shared/services/product.service';
import { Pagination } from '@/shared/classes';
import Spinner from '@/components/shared/spinner/Spinner';

export default {
  name: 'ProductList',
  components: {
    ProductCard,
    Spinner
  },
  props: {
    selectedType: {
      type: String,
      default: 'newest'
    },
    selectedColors: {
      type: Array,
      default() {
        return [];
      }
    },
    selectedSizes: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  data() {
    return {
      loading: false,
      products: [],
      pagination: new Pagination()
    };
  },
  computed: {
    category() {
      return this.$route.params.slug;
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
      return this.selectedColors.join(',');
    },
    sizesString() {
      return this.selectedSizes.join(',');
    }
  },
  watch: {
    selectedType(newValue) {
      this.$router.push({name: 'Category', params: {slug: this.category, type: newValue}, query: { colors: this.colors, sizes: this.sizes }});
    },
    colorsString(newValue) {
      this.$router.push({name: 'Category', params: {slug: this.category, type: this.type}, query: { colors: newValue, sizes: this.sizes }});
    },
    sizesString(newValue) {
      this.$router.push({name: 'Category', params: {slug: this.category, type: this.type}, query: { colors: this.colors, sizes: newValue }});
    },
    colors(newValue) {
      this.products = [];
      this.getProducts();
    },
    sizes(newValue) {
      this.products = [];
      this.getProducts();
    },
    category() {
      this.products = [];
      this.getProducts();
    },
    type() {
      this.products = [];
      this.getProducts();
    }
  },
  methods: {
    getProducts(page) {
      if (!this.loading) {
        this.loading = true;

        productService.getByCategory({
          category: this.category,
          type: this.type
        }, page)
          .then(response => {
            if (response && response.status === 200 && response.data) {
              if (this.products.length) {
                this.products = this.products.concat(response.data.data);
              } else {
                this.products = response.data.data;
              }
              if (!response.data.next_page_url) {
                document.removeEventListener('scroll', this.onScroll);
              }

              this.pagination.total = response.data.total;
              this.pagination.current = response.data.current_page;
              this.pagination.perPage = response.data.per_page;
              this.loading = false;
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
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.product-list {
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .fa-spinner {
    font-size: 2rem;
    animation: spin 2s linear infinite;
  }
}
</style>
