<template>
  <div>
    <category-list :categories="hierarchyCategories"></category-list>
  </div>
</template>

<script>
import categoryService from '@/shared/services/category.service';
import CategoryList from './CategoryList';

export default {
  components: {
    CategoryList
  },
  data() {
    return {
      categories: []
    };
  },
  computed: {
    hierarchyCategories() {
      const categories = [];

      this.categories.forEach(category => {
        if (category.parent_id) {
          const parent = this.categories.find(item => item.id === category.parent_id);
          if (parent) {
            if (!parent.children) {
              parent.children = [];
            }
            parent.children.push(category);
          }
        } else {
          categories.push(category);
        }
      });

      return categories;
    }
  },
  mounted() {
    categoryService.getAll()
      .then(response => {
        if (response.status === 200 && response.data) {
          this.categories = response.data;
        }
      });
  }
};
</script>

<style>

</style>
