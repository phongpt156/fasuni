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
    <edit-lookbook-modal :value="isOpenEditLookbookModal" :lookbook="selectedLookbook" @close="isOpenEditLookbookModal = false; selectedLookbook = {}" @updated="updated"></edit-lookbook-modal>
    <delete-lookbook-modal :value="isOpenDeleteLookbookModal" :lookbook="selectedLookbook" @close="isOpenDeleteLookbookModal = false; selectedLookbook = {}" @delete="onDelete"></delete-lookbook-modal>
  </div>
</template>

<script>
import lookbookService from '@/shared/services/lookbook.service';
import ResponsiveImage from '@/components/common/ResponsiveImage';
import EditLookbookModal from './EditLookbookModal';
import DeleteLookbookModal from './DeleteLookbookModal';
import { GENDER } from '@/shared/constants';

export default {
  components: {
    ResponsiveImage,
    EditLookbookModal,
    DeleteLookbookModal
  },
  data() {
    return {
      isOpenEditLookbookModal: false,
      isOpenDeleteLookbookModal: false,
      loading: false,
      lookbooks: [],
      selectedLookbook: {},
      columns: [
        {
          title: 'Tên',
          key: 'name',
          sortable: true
        },
        {
          title: 'Tên',
          key: 'Giới tính',
          sortable: true,
          render: (h, params) => {
            return h('span', Number(params.row.gender) === this.genders.male.id ? 'Nam' : 'Nữ');
          }
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
                  type: 'success',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    this.openEditLookbookModal(params.index);
                  }
                }
              }, 'Edit'),
              h('Button', {
                props: {
                  type: 'error',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.openDeleteLookbookModal(params.index);
                  }
                }
              }, 'Delete')
            ]);
          }
        }
      ]
    };
  },
  computed: {
    genders() {
      return GENDER;
    }
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
    updated(payload) {
      const index = this.lookbooks.indexOf(payload.oldLookbook);
      this.lookbooks[index].name = payload.newLookbook.name;
      this.lookbooks[index].gender = payload.newLookbook.gender;
      this.lookbooks[index].small_image = payload.newLookbook.small_image;
      this.lookbooks[index].medium_image = payload.newLookbook.medium_image;
      this.lookbooks[index].large_image = payload.newLookbook.large_image;
      this.lookbooks[index].thumbnail = payload.newLookbook.thumbnail;
    },
    onDelete(lookbook) {
      const index = this.lookbooks.indexOf(lookbook);
      this.lookbooks.splice(index, 1);
    },
    openEditLookbookModal(index) {
      this.selectedLookbook = this.lookbooks[index];
      this.isOpenEditLookbookModal = true;
    },
    openDeleteLookbookModal(index) {
      this.selectedLookbook = this.lookbooks[index];
      this.isOpenDeleteLookbookModal = true;
    }
  },
  mounted() {
    this.getLookbooks();
  }
};
</script>

<style>

</style>
