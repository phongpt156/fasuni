<template>
  <div>
    <router-link :to="{name: 'Product', params: {id: product.master_product_id || product.id}, query: product.color.length ? {color: product.color[0].id} : {}}">
      <img v-if="product.images.length" :src="product.images[0].original" :alt="product.name" class="img-fluid" />
      <img v-else :alt="product.name" class="img-fluid" />
    </router-link>
    <p class="text-center mb-0 product-name">{{ product.name }}</p>
  </div>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      default() {
        return {};
      }
    }
  }
};
</script>

<style>

</style>
