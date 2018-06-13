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
import collectionService from '@/shared/services/collection.service';
import ResponsiveImage from '@/components/common/ResponsiveImage';

export default {
  components: {
    ResponsiveImage
  },
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
        },
        {
          title: 'Cover',
          render: (h, params) => {
            return h('div', {
              attrs: {
                class: 'py-5'
              }
            }, [h(ResponsiveImage, {
              props: {
                sm: params.row.small_cover,
                md: params.row.medium_cover,
                lg: params.row.large_cover,
                thumbnail: params.row.thumbnail_cover
              }
            })]);
          }
        }
      ]
    };
  },
  methods: {
    getCollections() {
      collectionService.getAll()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.collections = response.data;
          }
        });
    }
  },
  mounted() {
    this.getCollections();
  }
};
</script>

<style>

</style>
