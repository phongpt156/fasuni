<template>
  <button :type="type" :class="{loading: loading}" class="mat-button" :disabled="loading">
    <spinner :loading="loading" class="mr-2"></spinner>
    {{ placeholder }}
  </button>
</template>

<script>
import Spinner from '@/components/shared/spinner/Spinner';

export default {
  components: {
    Spinner
  },
  props: {
    type: {
      type: String,
      default: 'button'
    },
    placeholder: {
      type: String,
      default: ''
    },
    loading: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style lang="scss">
.mat-button {
  .spinner {
    display: inline-block;

    .fa-spinner {
      font-size: 1rem !important;
    }
  }
}
</style>
