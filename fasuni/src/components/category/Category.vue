<template>
  <div class="category">
    <nav class="navbar navbar-expand-lg justify-content-center py-3 px-2">
      <div class="d-md-block d-none breadcrumbs">
        <ul class="navbar-nav align-items-center flex-row">
          <li class="nav-item" v-if="category && category.parent && category.parent.parent">
            <a class="nav-link p-2">{{ category.parent.parent.name }}
            </a>
          </li> /
          <li class="nav-item" v-if="category && category.parent">
            <a class="nav-link p-2">{{ category.parent.name }}
            </a>
          </li> /
          <li class="nav-item font-weight-bold" v-if="category">
            <a class="nav-link p-2">{{ category.name }}
            </a>
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
      category: {}
    };
  },
  computed: {
    slug() {
      return this.$route.params.slug;
    }
  },
  watch: {
    slug() {
      this.getHierachyCategory();
    }
  },
  methods: {
    getHierachyCategory() {
      categoryService.getHierachyCategory(this.slug)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.category = response.data;
          }
        });
    }
  },
  mounted() {
    this.getHierachyCategory();
  }
};
</script>

<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';

  .category {
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
