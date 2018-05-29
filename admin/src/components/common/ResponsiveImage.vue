<template>
  <picture>
    <source :srcset="`${imageUrl}/${lg}` | encodeURI" media="(min-width: 641px)" />
    <source :srcset="`${imageUrl}/${md}` | encodeURI" media="(min-width: 321)" />
    <source :srcset="`${imageUrl}/${md}` | encodeURI" media="(min-width: 76)" />
    <img :src="`${imageUrl}/${md}` | encodeURI" alt="" style="width: 225px; height: auto" />
  </picture>
</template>

<script>
import { IMAGE_URL } from '@/shared/constants';
import { encodeURI } from '@/filters';

export default {
  filters: {
    encodeURI
  },
  props: {
    sm: {
      type: String,
      default: ''
    },
    md: {
      type: String,
      default: ''
    },
    lg: {
      type: String,
      default: ''
    },
    thumbnail: {
      type: String,
      default: ''
    }
  },
  computed: {
    imageUrl() {
      return IMAGE_URL;
    }
  }
};
</script>

<style>

</style>
