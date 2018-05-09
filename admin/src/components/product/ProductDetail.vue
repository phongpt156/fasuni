<template>
  <div class="product-detail">
    <h6 class="text-primary mb-2">{{ product.name }}</h6>
    <div class="d-lg-flex">
      <div class="mr-4 product-image">
        <a v-if="selectedImage">
          <img :src="selectedImage.original" alt="" />
        </a>
      </div>
      <row class="mr-4">
        <i-col v-for="image in product.images" :key="image.id" class="mb-2">
          <div class="thumbnail">
            <a @click="selectImage(image)">
              <img :src="image.original" alt="" :class="{'selected': image === selectedImage}" />
            </a>
          </div>
        </i-col>
      </row>
      <div class="mr-4 text-nowrap" v-if="productAttributes(product).length">
        <h6 class="mb-2 text-primary">Thuộc tính:</h6>
        <p v-for="attribute in productAttributes(product)" :key="attribute.id">
          <span class="text-primary">{{ attribute.name }}:</span> {{ attribute.values[0].name }}
        </p>
      </div>
      <div v-if="product.sub_products && product.sub_products.length" class="w-100">
        <h6 class="mb-2 text-primary">Sản phẩm cùng loại:</h6>
        <collapse v-model="collapse" accordion>
          <panel v-for="subProduct in product.sub_products" :key="subProduct.id" :name="subProduct.name">
            <span class="text-primary">{{ subProduct.name }}</span>
            <div slot="content">
              <div class="d-flex">
                <div class="product-image mr-4" v-if="subProduct.images">
                  <img :src="subProduct.images[0].original" alt="" />
                </div>
                <div>
                  <p><span class="text-primary">Mã sản phẩm:</span> {{ subProduct.sku_id || subProduct.id }}</p>
                  <p><span class="text-primary">Nhóm sản phẩm:</span> {{ subProduct.category && subProduct.category.name || '&lt;&lt;Trống&gt;&gt;' }}</p>
                  <p><span class="text-primary">Giá bán:</span> {{ subProduct.price | getFormatPrice }}</p>
                  <p><span class="text-primary">Tồn kho:</span> {{ subProduct.quantity }}</p>
                </div>
              </div>
              <div v-if="productAttributes(subProduct).length" class="mt-2">
                <h6><span class="text-primary">Thuộc tính:</span></h6>
                <p v-for="attribute in productAttributes(subProduct)" :key="attribute.id">
                  <span class="text-primary">{{ attribute.name }}:</span> {{ attribute.values[0].name }}
                </p>
              </div>
            </div>
          </panel>
        </collapse>
      </div>
    </div>
  </div>
</template>

<script>
import { getFormatPrice } from '@/shared/functions';

export default {
  filters: {
    getFormatPrice
  },
  props: {
    product: {
      type: Object,
      default() {
        return {};
      }
    },
    attributes: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  data() {
    return {
      selectedImage: '',
      collapse: ''
    };
  },
  computed: {
    productAttributes: function () {
      return product => {
        console.log(product);
        const productAttributes = [];

        if (product.attribute_values) {
          this.attributes.forEach(attribute => {
            const tmp = product.attribute_values.filter(attributeValue => attributeValue.attribute.id === attribute.id);
            if (tmp.length) {
              productAttributes.push({
                id: attribute.id,
                name: attribute.name,
                values: tmp
              });
            }
          });
        }

        return productAttributes;
      };
    }
  },
  methods: {
    selectImage(image) {
      if (image !== this.selectedImage) {
        this.selectedImage = image;
      }
    }
  },
  mounted() {
    if (this.product.images) {
      this.selectedImage = this.product.images[0];
    }
  }
};
</script>

<style lang="scss">
.product-detail {
  .product-image {
    img {
      max-width: 300px;
      max-height: 300px;
    }
  }
  .thumbnail {
    img {
      opacity: .5;
      max-width: 70px;
      max-height: 70px;
    }
    .selected {
      opacity: 1;
    }
  }
}
</style>
