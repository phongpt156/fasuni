<template>
  <div class="collection">
    <responsive-image :lg="collection.large_cover" :md="collection.medium_cover" :sm="collection.small_cover" :thumbnail="collection.thumbnail_cover" image-class="w-100" v-if="collection.id"></responsive-image>
    <div class="my-4">
      <h6 class="text-uppercase mb-2 text-center">{{ collection.name }}</h6>
      <p class="mb-0 text-center px-5 w-50 mx-auto">{{ collection.description }}</p>
      <hr class="my-5 mx-5" />
      <div class="row mx-4">
        <product-card class="px-2 product-item" v-for="product in collection.products" :key="product.id" :product="product"></product-card>
      </div>
    </div>
    <div class="row">
      <div v-for="image in collection.images" :key="image.id" class="col-md-6">
        <img :src="`${imageUrl}/${image.original}`" alt="" style="max-width: 100%; max-height: 100%" />
      </div>
    </div>
  </div>
</template>

<script>
import collectionService from '@/shared/services/collection.service';
import ResponsiveImage from '@/components/shared/responsive-image/ResponsiveImage';
import ProductCard from '@/components/collection/ProductCard';
import { IMAGE_URL } from '@/shared/constants';

export default {
  components: {
    ResponsiveImage,
    ProductCard
  },
  data() {
    return {
      collection: {}
    };
  },
  computed: {
    id() {
      return this.$route.params.id;
    },
    imageUrl() {
      return IMAGE_URL;
    }
  },
  methods: {
    getCollection(id) {
      collectionService.getOne(id)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.collection = response.data;
            console.log(response);
          }
        });
    }
  },
  mounted() {
    this.getCollection(this.id);
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.collection {
  background-color: $white;

  hr {
    border: 1px solid $black;
  }

  .product-item {
    width: calc(100% / 5);

    &:hover {
      img {
        opacity: 0.7
      }
      .product-name {
        visibility: visible;
      }
    }

    .product-name {
      font-size: $font-size-sm;
      visibility: hidden;
    }
  }
}
</style>
