<template>
  <modal v-model="isOpenEditLookbookModal" @on-cancel="close" class="edit-lookbook">
    <p slot="header" style="color: #19be6b" class="text-center">
      <Icon type="information-circled" @click="close"></Icon>
      <span>Sửa lookbook</span>
    </p>
    <div>
      <i-form :model="editLookbookForm" :label-width="80" ref="editLookbookForm" @submit="onSubmit" class="text-left" @submit.native.prevent :rules="rules">
        <form-item label="Tên" prop="name">
          <i-input type="text" v-model="editLookbookForm.name"></i-input>
        </form-item>
        <form-item label="Ảnh" v-if="editLookbookForm.original_image">
          <img :src="`${imageBasePath}/${editLookbookForm.original_image}`" alt="" class="w-100" />
        </form-item>
        <form-item>
          <div class="demo-upload-list" v-for="item in uploadList" :key="item.uid">
            <template v-if="item.status === 'finished'">
              <div>
                <img :src="`${lookbookImageBasePath}/${item.url}`" />
              </div>
              <div class="demo-upload-list-cover">
                <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
              </div>
            </template>
            <template v-else>
              <progress v-if="item.showProgress" :percent="item.percentage" hide-info></progress>
            </template>
          </div>
          <upload
            ref="upload"
            :action="uploadLink"
            accept="image/*"
            :format="['jpg','jpeg','png']"
            :max-size="204800"
            type="drag"
            :on-success="onSuccess"
            :before-upload="beforeUpload"
            v-model="editLookbookForm.image">
            <div style="padding: 20px 0">
              <icon type="ios-cloud-upload" size="52" style="color: #3399ff"></icon>
              <p>Click or drag files here to upload</p>
            </div>
          </upload>
        </form-item>
        <form-item label="Sản phẩm">
          <multiselect
            v-model="editLookbookForm.products"
            :options="products"
            placeholder="Chọn sản phẩm"
            :searchable="true"
            track-by="id"
            :multiple="true"
            @search-change="searchProducts"
            :custom-label="customLabel">
            <template slot="option" slot-scope="props">
              <div class="d-flex align-items-center">
                <img class="mr-2" :src="props.option.images[0].original" :alt="props.option.name" style="width: 75px; height: 75px" v-if="props.option.images && props.option.images.length" />
                <span class="mr-4">{{props.option.code }} - {{ props.option.name }}
                  <template v-if="props.option.color.length">
                    - {{ props.option.color[0].name }}
                  </template>
                  <template v-if="props.option.size.length">
                    - {{ props.option.size[0].name }}
                  </template>
                </span>
              </div>
            </template>
          </multiselect>
        </form-item>
        <form-item label="Giới tính">
          <i-select
            v-model="editLookbookForm.gender"
            label="Chọn giới tính">
            <i-option v-for="gender in genders" :value="gender.id" :key="gender.id">
              {{ gender.name }}
            </i-option>
          </i-select>
        </form-item>
      </i-form>
    </div>
    <div slot="footer">
      <i-button type="success" size="large" :loading="loading" html-type="submit" @click="onSubmit">Xác nhận</i-button>
    </div>
  </modal>
</template>

<script>
import { IMAGE } from '@/shared/constants/api';
import { IMAGE_URL, LOOKBOOK_IMAGE_URL, GENDER, ERROR_MESSAGE } from '@/shared/constants';
import lookbookService from '@/shared/services/lookbook.service';
import Multiselect from 'vue-multiselect';

export default {
  components: {
    Multiselect
  },
  props: {
    value: {
      type: Boolean,
      value: false
    },
    lookbook: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  data() {
    return {
      loading: false,
      isOpenEditLookbookModal: false,
      rules: {
        name: { required: true, message: ERROR_MESSAGE.lookbook.name.required, trigger: 'blur' }
      },
      uploadLink: IMAGE.uploadLookbook,
      uploadList: [],
      products: [],
      editLookbookForm: {}
    };
  },
  computed: {
    customLabel: () => option => {
      return `${option.code} - ${option.name}`;
    },
    genders() {
      return GENDER;
    },
    imageBasePath() {
      return IMAGE_URL;
    },
    lookbookImageBasePath() {
      return LOOKBOOK_IMAGE_URL;
    },
    id() {
      return this.lookbook.id;
    }
  },
  watch: {
    value(newValue) {
      this.isOpenEditLookbookModal = newValue;
    },
    id(newValue) {
      if (newValue) {
        this.getLookbook(newValue);
      }
    }
  },
  methods: {
    close() {
      this.$emit('close');
    },
    edit() {

    },
    handleRemove (file) {
      this.uploadList.splice(this.uploadList.indexOf(file), 1);
      this.editLookbookForm.original_image = '';
    },
    onSubmit() {
      this.$refs.editLookbookForm.validate(valid => {
        if (valid) {
          if (!this.editLookbookForm.original_image & !this.uploadList.length) {
            this.$Message.error('Chưa chọn ảnh lookbook!');
          } else if (!this.editLookbookForm.products.length) {
            this.$Message.error('Chưa chọn sản phẩm!');
          } else {
            this.loading = true;

            if (this.uploadList.length) {
              this.editLookbookForm.image = this.uploadList[0].url;
            }

            const body = JSON.parse(JSON.stringify(this.editLookbookForm));
            body.products = body.products.map(product => product.id);

            lookbookService.update(body.id, body)
              .then(response => {
                this.loading = false;

                if (response && response.status === 200 && response.data) {
                  this.$Message.success('Success');
                  this.$emit('updated', {
                    newLookbook: response.data,
                    oldLookbook: this.lookbook
                  });
                  this.$emit('close');
                }
              });
          }
        } else {
          this.$refs.editLookbookForm.$el[0].focus();
          this.$Message.error('Fail!');
        }
      });
    },
    onSuccess(response, file, fileList) {
      fileList.splice(0);
      fileList.push(file);
      file.url = response.url;
      this.editLookbookForm.original_image = `lookbooks/${response.url}`;
      this.loading = false;
    },
    beforeUpload() {
      this.loading = true;
    },
    searchProducts(name) {
      const query = {};

      if (name) {
        query.name = name;
      }

      lookbookService.searchProducts(query)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.products = response.data;
          }
        });
    },
    getLookbook(id) {
      lookbookService.getOne(id)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.editLookbookForm = response.data;
          }
        });
    }
  },
  mounted() {
    this.uploadList = this.$refs.upload.fileList;
    this.searchProducts();
  }
};
</script>

<style lang="scss">
@import 'vue-multiselect/dist/vue-multiselect.min.css';

.ivu-message {
  z-index: 9999;
}

.ivu-modal-wrap {
  z-index: 9999;
}

.edit-lookbook {
  .demo-upload-list {
    width: 5%;
    text-align: center;
    position: relative;
    overflow: hidden;
    min-width: 60px;
    margin-right: 4px;
    line-height: 60px;
    height: 5%;
    display: inline-block;
    box-shadow: 0 1px 1px rgba(0,0,0,.2);
    border-radius: 4px;
    border: 1px solid transparent;
    background: #fff;

    &-cover {
      top: 0;
      right: 0;
      position: absolute;
      left: 0;
      display: none;
      bottom: 0;
      background: rgba(0,0,0,.6);

      i {
        margin: 0 2px;
        font-size: 20px;
        cursor: pointer;
        color: #fff;
      }
    }
    &:hover {
      .demo-upload-list-cover {
        justify-content: center;
        display: flex;
        align-items: center;
      }
    }

    img {
      width: 100%;
      height: 100%;
    }
  }
  .ivu-upload-list {
    display: none;
  }
  .multiselect__tags {
    padding-top: 5px;
  }
}
</style>
