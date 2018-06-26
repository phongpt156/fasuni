<template>
  <div>
    <modal
      v-if="isOpenConfirmDeleteOrderDialog"
      @close="$emit('update:isOpenConfirmDeleteOrderDialog', false)"
      size="md">
      <div slot="body" class="py-2 px-3 font-size-sm">
        <p class="px-2">
          Bạn có chắc muốn hủy đơn hàng {{ code }} không?
        </p>
        <div class="text-right">
          <button class="btn btn-default font-size-sm" @click="$emit('update:isOpenConfirmDeleteOrderDialog', false)">Hủy</button>
          <mat-button class="btn btn-danger font-size-sm" placeholder="Đồng ý" :loading="loading" @click.native="$emit('delete')"></mat-button>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import Modal from '@/components/shared/Modal';
import MatButton from '@/components/shared/material/MatButton';

export default {
  props: {
    isOpenConfirmDeleteOrderDialog: {
      type: Boolean,
      default: false
    },
    code: {
      type: String,
      default: ''
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  components: {
    Modal,
    MatButton
  }
};
</script>

<style>

</style>
