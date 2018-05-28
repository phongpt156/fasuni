<template>
  <div class="add-lookbook">
    <div class="text-right mb-3">
      <i-form :model="addLookbookForm" :label-width="80" ref="addLookbookForm" @submit="onSubmit" class="text-left">
        <form-item label="Tên">
          <i-input type="text" v-model="addLookbookForm.name"></i-input>
        </form-item>
        <form-item label="Ảnh">
          <div class="demo-upload-list" v-for="item in uploadList" :key="item.uid">
            <template v-if="item.status === 'finished'">
              <div>
                <img :src="item.url">
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
            :max-size="2048"
            type="drag"
            :on-success="onSuccess">
            <div style="padding: 20px 0">
              <icon type="ios-cloud-upload" size="52" style="color: #3399ff"></icon>
              <p>Click or drag files here to upload</p>
            </div>
          </upload>
        </form-item>
        <form-item>
          <i-button type="success" @click="onSubmit">Submit</i-button>
        </form-item>
      </i-form>
      <modal title="View Image" v-model="visible">
        <img :src="imgUrl" v-if="visible" style="width: 100%">
        <div slot="footer">
          <i-button type="success" @click="visible = false">Đóng</i-button>
        </div>
      </modal>
    </div>
  </div>
</template>

<script>
import { IMAGE } from '@/shared/constants/api';
import { IMAGES_URL } from '@/shared/constants';

export default {
  data() {
    return {
      addLookbookForm: {
        name: '',
        image: ''
      },
      uploadLink: IMAGE.upload,
      uploadList: [],
      imgUrl: '',
      visible: false
    };
  },
  methods: {
    handleView (url) {
      this.imgUrl = url;
      this.visible = true;
    },
    handleRemove (file) {
      const fileList = this.$refs.upload.fileList;
      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
    },
    onSubmit() {
      console.log(IMAGE);
    },
    onSuccess(response, file, fileList) {
      fileList.splice(0);
      fileList.push(file);
      file.url = `${IMAGES_URL}/${response.url}`;
      console.log(fileList);
    }
  },
  mounted() {
    this.uploadList = this.$refs.upload.fileList;
  }
};
</script>

<style lang="scss">
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
}
</style>
