<template>
  <div class="add-lookbook">
    <div class="text-right mb-3">
      <i-form :model="addLookbookForm" :label-width="80" ref="addLookbookForm" @submit="onSubmit" class="text-left" @submit.native.prevent :rules="rules">
        <form-item label="Tên" prop="name">
          <i-input type="text" v-model="addLookbookForm.name"></i-input>
        </form-item>
        <form-item label="Ảnh">
          <div class="demo-upload-list" v-for="item in uploadList" :key="item.uid">
            <template v-if="item.status === 'finished'">
              <div>
                <img :src="`${imageBasePath}/${item.url}`" />
              </div>
              <div class="demo-upload-list-cover">
                <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
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
            v-model="addLookbookForm.image">
            <div style="padding: 20px 0">
              <icon type="ios-cloud-upload" size="52" style="color: #3399ff"></icon>
              <p>Click or drag files here to upload</p>
            </div>
          </upload>
        </form-item>
        <form-item label="Sản phẩm">
          <multiselect
            v-model="addLookbookForm.products"
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
            v-model="addLookbookForm.gender"
            label="Chọn giới tính">
            <i-option v-for="gender in genders" :value="gender.id" :key="gender.id">
              {{ gender.name }}
            </i-option>
          </i-select>
        </form-item>
        <form-item>
          <i-button type="success" @click="onSubmit" :loading="loading">Submit</i-button>
        </form-item>
      </i-form>
      <modal title="View Image" v-model="visible">
        <img :src="imgUrl" v-if="visible" style="width: 100%" />
        <div slot="footer">
          <i-button type="success" @click="visible = false">Đóng</i-button>
        </div>
      </modal>
    </div>
  </div>
</template>

<script>
import { IMAGE } from '@/shared/constants/api';
import { LOOKBOOK_IMAGE_URL, GENDER, ERROR_MESSAGE } from '@/shared/constants';
import lookbookService from '@/shared/services/lookbook.service';
import Multiselect from 'vue-multiselect';

export default {
  components: {
    Multiselect
  },
  data() {
    return {
      addLookbookForm: {
        name: '',
        image: '',
        products: [],
        gender: GENDER.female.id
      },
      rules: {
        name: { required: true, message: ERROR_MESSAGE.lookbook.name.required, trigger: 'blur' }
      },
      uploadLink: IMAGE.uploadLookbook,
      uploadList: [],
      imgUrl: '',
      visible: false,
      loading: false,
      products: []
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
      return LOOKBOOK_IMAGE_URL;
    }
  },
  methods: {
    handleView (url) {
      this.imgUrl = `${LOOKBOOK_IMAGE_URL}/${url}`;
      this.visible = true;
    },
    handleRemove (file) {
      const fileList = this.$refs.upload.fileList;
      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
    },
    onSubmit() {
      this.$refs.addLookbookForm.validate(valid => {
        if (valid) {
          if (!this.$refs.upload.fileList.length) {
            this.$Message.error('Chưa chọn ảnh lookbook!');
          } else {
            this.loading = true;
            this.addLookbookForm.image = this.$refs.upload.fileList[0].url;

            const body = JSON.parse(JSON.stringify(this.addLookbookForm));
            body.products = body.products.map(product => product.id);

            lookbookService.store(body)
              .then(response => {
                if (response && response.status === 200 && response.data) {
                  this.loading = false;
                  this.$Message.success('Success');
                  this.$router.push({name: 'Lookbook'});
                }
              });
          }
        } else {
          this.$refs.addLookbookForm.$el[0].focus();
          this.$Message.error('Fail!');
        }
      });
    },
    onSuccess(response, file, fileList) {
      fileList.splice(0);
      fileList.push(file);
      file.url = response.url;
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
    getPrepareSaveName() {
      lookbookService.getPrepareSaveName()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.addLookbookForm.name = response.data;
          }
        });
    }
  },
  mounted() {
    this.uploadList = this.$refs.upload.fileList;
    this.getPrepareSaveName();
    this.searchProducts();
  }
};
</script>

<style lang="scss">
@import 'vue-multiselect/dist/vue-multiselect.min.css';

.ivu-message {
  z-index: 9999;
}

.add-lookbook {
  .demo-upload-list {
    width: 5%;
    text-align: center;
    position: relative;
    overflow: hidden;
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
