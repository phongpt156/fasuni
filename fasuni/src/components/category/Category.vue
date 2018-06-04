<template>
  <div class="category">
    <nav class="navbar navbar-expand-lg justify-content-center py-3 px-2">
      <div class="d-md-block d-none breadcrumbs">
        <ul class="navbar-nav align-items-center flex-row">
          <li class="nav-item d-flex align-items-center" v-for="(breadcrumb, index) in breadcrumbs" :key="breadcrumb.id">
            <div class="nav-link p-2" :class="{'font-weight-bold': index + 1 === breadcrumbsLength}">{{ breadcrumb.name }}
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
      breadcrumbs: []
    };
  },
  computed: {
    slug() {
      return this.$route.params.slug;
    },
    breadcrumbsLength() {
      return this.breadcrumbs.length;
    }
  },
  watch: {
    slug(newValue) {
      this.getHierachyCategory(newValue);
    },
    category(newValue) {
      this.setBreadcrumbs(newValue);
    }
  },
  methods: {
    getHierachyCategory(slug) {
      categoryService.getHierachyCategory(slug)
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
    }
  },
  mounted() {
    this.getHierachyCategory(this.slug);
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.category {
  min-height: calc(100vh - 322px);

  .breadcrumbs {
    position: absolute;
    left: 0.5rem;
    font-size: $font-size-sm;
  }
  .hr {
    border-top: 1.5px solid rgba(0, 0, 0, 0.1);
    background-color: rgba(45, 45, 45, .2);
  }
}
</style>
