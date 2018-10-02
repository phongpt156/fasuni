<template>
  <picture>
    <source :srcset="`${imageUrl}/${lg}` | encodeURI" media="(min-width: 1201px)" />
    <source :srcset="`${imageUrl}/${md}` | encodeURI" media="(min-width: 641px)" />
    <source :srcset="`${imageUrl}/${sm}` | encodeURI" media="(min-width: 321)" />
    <source :srcset="`${imageUrl}/${thumbnail}` | encodeURI" media="(min-width: 76)" />
    <img :src="`${imageUrl}/${md}` | encodeURI" alt="" :class="imageClass" />
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
      type: String
    },
    md: {
      type: String
    },
    lg: {
      type: String
    },
    thumbnail: {
      type: String
    },
    imageClass: {
      type: String
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
