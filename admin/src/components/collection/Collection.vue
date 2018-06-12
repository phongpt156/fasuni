<template>
  <div class="lookbook">
    <router-view></router-view>
    <div class="text-right mb-3">
      <i-button type="success" @click="$router.push({name: 'AddCollection'})">Thêm bộ sưu tập</i-button>
    </div>
    <i-table
      :data="collections"
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
      collections: [],
      columns: [
        {
          title: 'Tên',
          key: 'name',
          sortable: true
        },
        {
          title: 'Mô tả',
          key: 'description',
          sortable: true
        }
      ]
    };
  }
};
</script>

<style>

</style>
