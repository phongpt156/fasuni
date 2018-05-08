<template>
  <div class="homepage">
    <div style="height: 600px">
      <i-button type="success" :loading="syncing" @click="syncing = !syncing">Đồng bộ dữ liệu với KiotViet</i-button>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      syncing: false
    };
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
</style>
