<template>
  <router-view></router-view>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      lookbooks: [],
      columns: [
        {
          title: 'Tên lookbook',
          key: 'name',
          sortable: true
        }
      ]
    };
  }
};
</script>

<style>

</style>
