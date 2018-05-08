<template>
  <div>
    <component :is="currentLayout" v-if="currentLayout">
      <router-view></router-view>
    </component>
    <router-view v-else>
    </router-view>
  </div>
</template>

<script>
export default {
  props: {
    layouts: {
      type: Object,
      default() {
        return {};
      }
    },
    current: {
      type: String,
      default: ''
    }
  },
  computed: {
    currentLayout() {
      return this.layouts[this.current];
    }
  }
};
</script>

<style>

</style>
