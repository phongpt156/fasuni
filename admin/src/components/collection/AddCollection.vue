<template>
  <div class="add-collection">
    <div class="text-right mb-3">
      <i-form :model="addCollectionForm" :label-width="80" ref="addCollectionForm" @submit="onSubmit" class="text-left" @submit.native.prevent :rules="rules">
        <form-item label="Tên" prop="name">
          <i-input type="text" v-model="addCollectionForm.name"></i-input>
        </form-item>
        <form-item label="Mô tả" prop="description">
          <i-input v-model="addCollectionForm.description" type="textarea" :rows="4"></i-input>
        </form-item>
        <form-item label="Cover">
          <div class="demo-upload-list" v-for="item in coverUploadList" :key="item.uid">
            <template v-if="item.status === 'finished'">
              <div>
                <img :src="`${imageBasePath}/${item.response.url}`" />
              </div>
              <div class="demo-upload-list-cover">
                <Icon type="ios-eye-outline" @click.native="handleView(item.response.url)"></Icon>
                <Icon type="ios-trash-outline" @click.native="handleRemoveCover(item)"></Icon>
              </div>
            </template>
            <template v-else>
              <progress v-if="item.showProgress" :percent="item.percentage" hide-info></progress>
            </template>
          </div>
          <upload
            ref="coverUpload"
            :action="uploadLink"
            accept="image/*"
            :format="['jpg','jpeg','png']"
            :max-size="204800"
            type="drag"
            v-model="addCollectionForm.cover"
            :on-success="uploadedCover">
            <div style="padding: 20px 0">
              <icon type="ios-cloud-upload" size="52" style="color: #3399ff"></icon>
              <p>Click or drag files here to upload</p>
            </div>
          </upload>
        </form-item>
        <form-item label="Ảnh">
          <div class="demo-upload-list" v-for="item in uploadList" :key="item.uid">
            <template v-if="item.status === 'finished'">
              <div>
                <img :src="`${imageBasePath}/${item.response.url}`" />
              </div>
              <div class="demo-upload-list-cover">
                <Icon type="ios-eye-outline" @click.native="handleView(item.response.url)"></Icon>
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
            v-model="addCollectionForm.images">
            <div style="padding: 20px 0">
              <icon type="ios-cloud-upload" size="52" style="color: #3399ff"></icon>
              <p>Click or drag files here to upload</p>
            </div>
          </upload>
        </form-item>
        <form-item label="Sản phẩm">
          <multiselect
            v-model="addCollectionForm.products"
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
                  <template v-if="props.option.color">
                    - {{ props.option.color.name }}
                  </template>
                  <template v-if="props.option.size">
                    - {{ props.option.size.name }}
                  </template>
                </span>
              </div>
            </template>
          </multiselect>
        </form-item>
        <form-item>
          <i-button type="success" @click="onSubmit">Submit</i-button>
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
import { COLLECTION_IMAGE_URL, ERROR_MESSAGE } from '@/shared/constants';
import collectionService from '@/shared/services/collection.service';
import lookbookService from '@/shared/services/lookbook.service';
import Multiselect from 'vue-multiselect';

export default {
  components: {
    Multiselect
  },
  data() {
    return {
      addCollectionForm: {
        name: '',
        description: '',
        images: [],
        products: [],
        cover: ''
      },
      rules: {
        name: { required: true, message: ERROR_MESSAGE.collection.name.required, trigger: 'change' }
      },
      uploadLink: IMAGE.uploadCollection,
      coverUploadList: [],
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
    imageBasePath() {
      return COLLECTION_IMAGE_URL;
    }
  },
  methods: {
    handleView (url) {
      this.imgUrl = `${COLLECTION_IMAGE_URL}/${url}`;
      this.visible = true;
    },
    handleRemove (file) {
      this.uploadList.splice(this.uploadList.indexOf(file), 1);
    },
    handleRemoveCover (file) {
      this.coverUploadList.splice(this.coverUploadList.indexOf(file), 1);
    },
    onSubmit() {
      this.$refs.addCollectionForm.validate(valid => {
        if (valid) {
          if (!this.coverUploadList.length) {
            this.$Message.error('Chưa chọn ảnh cover bộ sưu tập!');
          } else if (!this.uploadList.length) {
            this.$Message.error('Chưa chọn ảnh bộ sưu tập!');
          } else if (!this.addCollectionForm.products.length) {
            this.$Message.error('Chưa chọn sản phẩm!');
          } else {
            this.loading = true;
            this.addCollectionForm.images = this.uploadList;
            this.addCollectionForm.cover = this.coverUploadList;

            const body = JSON.parse(JSON.stringify(this.addCollectionForm));
            body.products = body.products.map(product => product.id);

            collectionService.store(body)
              .then(response => {
                if (response && response.status === 200 && response.data) {
                  this.loading = false;
                  this.$Message.success('Success');
                  this.$router.push({name: 'Collection'});
                }
              });
          }
        } else {
          this.$refs.addCollectionForm.$el[0].focus();
          this.$Message.error('Fail!');
        }
      });
    },
    uploadedCover(response, file, fileList) {
      fileList.splice(0, fileList.length - 1);
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
    }
  },
  mounted() {
    this.uploadList = this.$refs.upload.fileList;
    this.coverUploadList = this.$refs.coverUpload.fileList;
    this.searchProducts();
  }
};
</script>

<style lang="scss">
@import 'vue-multiselect/dist/vue-multiselect.min.css';

.ivu-message {
  z-index: 9999;
}

.add-collection {
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
