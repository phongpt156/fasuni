<template>
  <collapse v-model="collapse" accordion>
    <panel v-for="category in categories" :key="category.id" :name="category.name">
      {{ category.name }}
      <template v-if="category.children && category.children.length">
        <div slot="content">
          <category-list :categories="category.children"></category-list>
        </div>
      </template>
    </panel>
  </collapse>
</template>

<script>
import CategoryList from './CategoryList';

export default {
  name: 'category-list',
  components: {
    CategoryList
  },
  props: {
    categories: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  data() {
    return {
      collapse: ''
    };
  }
};
</script>

<style>

</style>
