<template>
  <div class="category-page">
    <nav class="navbar navbar-expand-lg justify-content-center py-3 px-2">
      <div class="d-md-block d-none breadcrumbs font-size-sm">
        <ul class="navbar-nav align-items-center flex-row pl-4 ml-2">
          <li class="nav-item d-flex align-items-center" v-for="(breadcrumb, index) in breadcrumbs" :key="breadcrumb.id">
            <div class="nav-link p-2" :class="{'font-weight-bold': index + 1 === breadcrumbsLength}">
              <template v-if="index + 1 < breadcrumbsLength">
                <router-link :to="{name: 'Category', params: {id: breadcrumb.id}}">{{ breadcrumb.name }}</router-link>
              </template>
              <template v-else>
                {{ breadcrumb.name }}
              </template>
            </div>
            <span v-if="index + 1 < breadcrumbsLength">/</span>
          </li>
        </ul>
      </div>
      <h3 class="text-uppercase font-weight-normal mb-0">Thời trang nam mùa hè</h3>
    </nav>
    <hr class="hr m-0" />
    <main-body></main-body>
  </div>
</template>

<script>
import MainBody from './main-body/MainBody';
import categoryService from '@/shared/services/category.service';
import productService from '@/shared/services/product.service';
import { mapMutations, mapState } from 'vuex';
import { Pagination } from '@/shared/classes';

export default {
  created() {
    if (!this.$route.params.type) {
      this.$router.push({name: 'Category', params: {type: 'newest'}});
    }
  },
  name: 'Category',
  components: {
    MainBody
  },
  data() {
    return {
      category: {},
      breadcrumbs: [],
      pagination: new Pagination()
    };
  },
  computed: {
    ...mapState('products', [
      'products',
      'loading',
      'filterButton'
    ]),
    id() {
      return this.$route.params.id;
    },
    breadcrumbsLength() {
      return this.breadcrumbs.length;
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
    id(newValue) {
      document.addEventListener('scroll', this.onScroll, {
        passive: true
      });
      this.getHierachyCategory(newValue);
      this.setEmptyProducts();
      this.getProducts(1);
    },
    category(newValue) {
      this.setBreadcrumbs(newValue);
      document.addEventListener('scroll', this.onScroll, {
        passive: true
      });
    },
    colorsString(newValue) {
      this.$router.push({name: this.$route.name, params: {id: this.id, type: this.type}, query: { colors: newValue, sizes: this.sizes }});
    },
    sizesString(newValue) {
      this.$router.push({name: this.$route.name, params: {id: this.id, type: this.type}, query: { colors: this.colors, sizes: newValue }});
    },
    colors(newValue) {
      this.setEmptyProducts();
      this.getProducts(1);
      document.addEventListener('scroll', this.onScroll, {
        passive: true
      });
    },
    sizes(newValue) {
      this.setEmptyProducts();
      this.getProducts(1);
      document.addEventListener('scroll', this.onScroll, {
        passive: true
      });
    },
    type(newValue) {
      this.setEmptyProducts();
      this.getProducts(1);
      document.addEventListener('scroll', this.onScroll, {
        passive: true
      });
    }
  },
  methods: {
    ...mapMutations('products', [
      'setLoading',
      'setEmptyProducts',
      'setProducts'
    ]),
    getHierachyCategory(id) {
      categoryService.getHierachyCategory(id)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.category = response.data;
          }
        });
    },
    setBreadcrumbs(category) {
      let tmp = JSON.parse(JSON.stringify(this.category));
      this.breadcrumbs = [];

      while (tmp) {
        this.breadcrumbs.unshift({
          id: tmp.id,
          name: tmp.name
        });

        tmp = tmp.parent;
      }
    },
    getProducts(page) {
      if (!this.loading) {
        this.setLoading(true);

        productService.getByCategory({
          category: this.id,
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

      if (document.documentElement.scrollTop + window.innerHeight >= document.documentElement.scrollHeight - footerHeight - 100) {
        this.getProducts(this.pagination.current + 1);
      }
    }
  },
  mounted() {
    this.getHierachyCategory(this.id);
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
.category-page {
  a {
    color: #212529;

    &:hover {
      text-decoration: none;
    }
  }

  min-height: calc(100vh - 322px);

  .breadcrumbs {
    position: absolute;
    left: 0.5rem;
  }
  .hr {
    border-top: 1.5px solid rgba(0, 0, 0, 0.1);
    background-color: rgba(45, 45, 45, .2);
  }
}
</style>
