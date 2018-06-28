<template>
  <div class="spinner" v-if="loading">
    <font-awesome-icon :icon="icons.spinner"></font-awesome-icon>
  </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import faSpinner from '@fortawesome/fontawesome-free-solid/faSpinner';

export default {
  components: {
    FontAwesomeIcon
  },
  props: {
    loading: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      icons: {
        spinner: faSpinner
      }
    };
  }
};
</script>

<style lang="scss">
.spinner {
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .fa-spinner {
    font-size: 2rem;
    animation: spin 2s linear infinite;
  }
}
</style>
