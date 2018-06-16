<template>
  <modal v-model="isOpenDeleteLookbookModal" width="360" @on-cancel="close">
    <p slot="header" style="color:#f60" class="text-center">
      <Icon type="information-circled"></Icon>
      <span>Delete confirmation</span>
    </p>
    <div class="text-center">
      <p>Bạn có chắc muốn xóa lookbook "{{ lookbook.name }}" không?</p>
    </div>
    <div slot="footer">
      <i-button type="error" size="large" long :loading="loading" @click="onDelete">Delete</i-button>
    </div>
  </modal>
</template>

<script>
import lookbookService from '@/shared/services/lookbook.service';

export default {
  props: {
    value: {
      type: Boolean,
      default: false
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
      isOpenDeleteLookbookModal: false
    };
  },
  watch: {
    value(newValue) {
      this.isOpenDeleteLookbookModal = newValue;
    }
  },
  methods: {
    close() {
      this.$emit('close');
    },
    onDelete(product) {
      this.loading = true;
      lookbookService.delete(this.lookbook.id)
        .then(response => {
          this.loading = false;
          this.$emit('delete', this.lookbook);
          this.$emit('close');
          this.$Message.success('Success');
        });
    }
  }
};
</script>

<style>

</style>
