<template>
  <div>Search Page
    <main-body></main-body>
  </div>
</template>

<script>
import MainBody from '@/components/category/main-body/MainBody';

export default {
  created() {
    if (!this.$route.params.type) {
      this.$router.push({name: 'Search', params: {type: 'newest'}});
    }
  },
  components: {
    MainBody
  }
};
</script>

<style>

</style>
