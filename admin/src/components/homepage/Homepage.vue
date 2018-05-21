<template>
  <div class="homepage">
    <div style="height: 600px">
      <i-button type="success" :loading="syncing" @click="sync">Đồng bộ dữ liệu với KiotViet</i-button>
    </div>
  </div>
</template>

<script>
import kiotvietService from '@/shared/services/kiotviet.service';

export default {
  data () {
    return {
      syncing: false
    };
  },
  methods: {
    sync() {
      this.syncing = true;

      kiotvietService.sync()
        .then(response => {
          this.syncing = false;
          if (response && response.status === 200 && response.data) {
            this.$toasted.show('Đồng bộ dữ liệu với KiotViet thành công!', {
              theme: 'bubble',
              position: 'top-center',
              type: 'success',
              duration: 5000
            });
          } else {
            this.$toasted.show(response.data.error, {
              theme: 'bubble',
              position: 'top-center',
              duration: 5000,
              type: 'error'
            });
          }
        });
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.homepage {
}
.toasted {
  &.success {
    background: #19be6b !important;
  }
}
</style>
