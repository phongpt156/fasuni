<template>
  <div>
    <modal
      v-if="isOpenSuccessDeleteOrderDialog"
      @close="$emit('update:isOpenSuccessDeleteOrderDialog', false)"
      size="sm">
      <div slot="body" class="py-2 px-3 font-size-sm">
        <p class="px-2">
          Đơn hàng của bạn đã được hủy :(
          Fasuni mong được tiếp tục phục vụ bạn trong tương lai.
        </p>
        <div class="text-right">
          <button class="btn btn-default font-size-sm" @click="$emit('update:isOpenSuccessDeleteOrderDialog', false)">Đóng</button>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import Modal from '@/components/shared/Modal';

export default {
  props: {
    isOpenSuccessDeleteOrderDialog: {
      type: Boolean,
      default: false,
    },
    code: {
      type: String,
      default: '',
    },
  },
  components: {
    Modal,
  },
};
</script>

<style>

</style>
