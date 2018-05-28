<template>
  <div class="lookbook">
    <router-view></router-view>
    <div class="text-right mb-3">
      <i-button type="success" @click="$router.push({name: 'AddLookbook'})">Thêm lookbook</i-button>
    </div>
    <i-table
      :data="lookbooks"
      :columns="columns"
      :loading="loading">
    </i-table>
  </div>
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
  },
  mounted() {
    console.log(this.$route);
  }
};
</script>

<style>

</style>
