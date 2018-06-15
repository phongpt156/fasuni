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
import lookbookService from '@/shared/services/lookbook.service';
import ResponsiveImage from '@/components/common/ResponsiveImage';

export default {
  components: {
    ResponsiveImage
  },
  data() {
    return {
      loading: false,
      lookbooks: [],
      columns: [
        {
          title: 'Tên',
          key: 'name',
          sortable: true
        },
        {
          align: 'center',
          title: 'Ảnh',
          render: (h, params) => {
            return h('div', {
              attrs: {
                class: 'py-5'
              }
            }, [h(ResponsiveImage, {
              props: {
                sm: params.row.small_image,
                md: params.row.medium_image,
                lg: params.row.large_image,
                thumbnail: params.row.thumbnail
              }
            })]);
          }
        },
        {
          title: 'Action',
          key: 'action',
          width: 150,
          align: 'center',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                props: {
                  type: 'error',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.delete(params.index);
                  }
                }
              }, 'Delete')
            ]);
          }
        }
      ]
    };
  },
  methods: {
    getLookbooks() {
      lookbookService.getAll()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.lookbooks = response.data;
          }
        });
    },
    delete(index) {
      lookbookService.delete(this.lookbooks[index].id);
      this.lookbooks.splice(index, 1);
    }
  },
  mounted() {
    this.getLookbooks();
  }
};
</script>

<style>

</style>
