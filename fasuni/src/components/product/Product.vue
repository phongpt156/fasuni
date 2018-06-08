<template>
  <div class="px-2 product-component">
    <div class="d-flex justify-content-center py-5" v-if="loading">
      <spinner :loading="loading"></spinner>
    </div>
    <div v-else>
      <template v-if="product.id">
        <ul class="navbar-nav align-items-center flex-row pt-4 pb-2 d-md-flex d-none">
          <li class="nav-item d-flex align-items-center" v-for="(breadcrumb, index) in breadcrumbs" :key="breadcrumb.id">
            <router-link class="nav-link p-2" v-if="index + 1 === breadcrumbsLength" :to="{name: 'Category', params: {id: breadcrumb.id}}">{{ breadcrumb.name }}
            </router-link>
            <div class="nav-link p-2" v-else>{{ breadcrumb.name }}
            </div>
            <span>/</span>
          </li>
          <li class="nav-item d-flex align-items-center">
            <div class="nav-link p-2 font-weight-bold">
              {{ selectedProduct.name }}
            </div>
          </li>
        </ul>
        <div>
          <div class="row m-0">
            <div class="col-md-8 p-0">
              <div class="row m-0">
                <div class="col-sm-6 p-2" v-for="image in images" :key="image.id">
                  <div class="image-wrapper image-standard">
                    <img :src="image.original" :alt="selectedProduct.name" class="img-fluid" />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="text-danger mt-2 font-weight-bold mb-4" style="line-height: normal">HOT</div>
              <div class="text-uppercase h4 mb-4">{{ selectedProduct.name }}</div>
              <template v-if="product.inventories">
                <div class="h5 mb-4 product-price">{{ selectedProduct.sale_price | priceFormat }}</div>
              </template>
              <div class="d-flex color-list mb-3">
                <router-link
                  v-for="color in colors"
                  :key="color.id"
                  :style="{backgroundColor: color.value}"
                  :to="{name: 'Product', params: {id: product.id}, query: {color: color.id}}"
                  class="mr-2 color-item d-flex align-items-center justify-content-center"
                  @click.native="selectColor(color)">
                  <font-awesome-icon class="text-white" :class="{'text-dark': !color.value}" :icon="icons.check" v-if="currentColor && currentColor.id === color.id"></font-awesome-icon>
                </router-link>
              </div>
              <div class="d-flex size-list">
                <a class="size-item px-2 py-1 d-flex justify-content-center align-items-center mr-2" v-for="size in sizes" :key="size.id" :class="{empty: !size.product.inventories || !size.product.inventories.length || !size.product.inventories[0].quantity, selected: selectedSize.id === size.id}" @click="selectSize(size)">
                  {{ size.name }}
                </a>
              </div>
              <!-- <select class="custom-select my-4" style="width: 106px" v-if="sizes.length" v-model="selectedSize">
                <option v-for="size in sizes" :key="size.id" :value="size">{{ size.name }}</option>
              </select> -->
              <div class="d-flex mt-2">
                <a class="mr-3 d-inline-flex align-items-center justify-content-center cart px-4 py-2" @click="addProductToCart({images, product: selectedSize.product})" :class="{'can-buy': selectedSize.id, 'text-white': selectedSize.id}">
                  <font-awesome-icon :icon="icons.cart" class="mr-2"></font-awesome-icon>
                  <span class="mt-1 font-size-sm">Thêm vào giỏ</span>
                </a>
                <a
                  class="d-inline-flex align-items-center justify-content-center like-button"
                  @click="toggleLiked">
                  <font-awesome-icon
                    :icon="icons.solidHeart"
                    v-if="selectedProduct.liked"></font-awesome-icon>
                  <font-awesome-icon
                    :icon="icons.regularHeart"
                    v-else></font-awesome-icon>
                </a>
              </div>
              <hr />
              <div class="info">
                <p class="mb-1 font-size-base">Thông tin</p>
                <p>Our best selling Balfern Biker Jacket receives a statement update this season with fringe tassels running across the back and front. Complete with our signature zip detailing, it's crafted from soft sheep nappa leather that gets more supple with each wear.</p>
                <p class="mb-1 font-size-base">Regular fit.</p>
                <p class="mb-0">- Fits true to size, take your normal size.</p>
                <p class="mb-0">- Model is 5'8" / 173cm, size UK 10.</p>
                <p class="mb-0">- See our size guide for more details.</p>
              </div>
              <hr />
              <p class="mb-0 text-uppercase font-size-base"><a @click="isOpenSizeGuideDialog = true">Size Guide</a></p>
              <hr />
              <div class="d-flex justify-content-between">
                <p class="mb-0 text-uppercase font-size-base">Chia sẻ</p>
                <div class="d-flex">
                  <a class="mx-2">
                    <font-awesome-icon :icon="icons.facebook" style="color: #3b5998"></font-awesome-icon>
                  </a>
                  <a class="mx-2">
                    <font-awesome-icon :icon="icons.instagram"></font-awesome-icon>
                    <svg width="0" height="0">
                      <radialGradient id="rg" r="150%" cx="30%" cy="107%">
                        <stop stop-color="#fdf497" offset="0" />
                        <stop stop-color="#fdf497" offset="0.05" />
                        <stop stop-color="#fd5949" offset="0.45" />
                        <stop stop-color="#d6249f" offset="0.6" />
                        <stop stop-color="#285AEB" offset="0.9" />
                      </radialGradient>
                    </svg>
                  </a>
                  <a class="mx-2">
                    <font-awesome-icon :icon="icons.youtube" style="color: #e52d27"></font-awesome-icon>
                  </a>
                  <a class="mx-2">
                    <font-awesome-icon :icon="icons.googlePlus" style="color: #df4b37"></font-awesome-icon>
                  </a>
                </div>
              </div>
              <hr />
              <p class="mb-2 text-uppercase font-size-base">Show us your style</p>
              <p class="mb-2">Share your Fasuni look using #FASUNI or upload <u><a>here</a></u> to be featured on fasuni.vn</p>
              <p class="mb-0 text-uppercase">#Fasuni</p>
            </div>
          </div>
        </div>
        <div class="mt-5">
          <p class="mb-0 text-center text-uppercase">Có thể bạn sẽ thích</p>
          <hr class="mt-0 mx-2" />
          <carousel :perPageCustom="[[768, 3], [1024, 4]]">
            <slide class="px-2" v-for="product in relevantProducts" :key="product.id">
              <a class="d-block image-wrapper image-standard">
                <img :src="product.images[0].original" alt="" class="img-fluid" v-if="product.images && product.images.length" />
                <img :alt="product.name" class="img-fluid" v-else />
              </a>
              <p class="font-size-base text-upper-case my-1">{{ product.name }}</p>
              <router-link class="detail-button" :to="{name: 'Product', params: {id: product.id}, query: {colors: product.color.id}}">Chi tiết >></router-link>
            </slide>
          </carousel>
        </div>
        <div class="py-5">
          <p class="mb-0 text-center text-uppercase">Xem gần đây</p>
          <hr class="mt-0 mx-2" />
          <carousel :perPageCustom="perPageCustom" v-if="recentlyViewedProducts.length">
            <slide class="px-2 recently-view-product" v-for="product in recentlyViewedProducts" :key="product.id">
              <template v-if="product.id === selectedProduct || product.color">
                <router-link
                  class="d-block image-wrapper image-standard"
                  :to="{name: 'Product', params: {id: product.id}, query: {color: product.color.id}}"
                  @click.native="selectColor(product.color)">
                  <img v-if="product.images && product.images.length" :src="product.images[0].original" alt="" />
                </router-link>
              </template>
              <template v-else>
                <router-link
                  class="d-block image-wrapper image-standard"
                  :to="{name: 'Product', params: {id: product.id}}">
                  <img v-if="product.images && product.images.length" :src="product.images[0].original" alt="" />
                </router-link>
              </template>
            </slide>
          </carousel>
        </div>
        <size-guide-dialog :isOpenSizeGuideDialog.sync="isOpenSizeGuideDialog"></size-guide-dialog>
      </template>
      <h1 v-else style="min-height: 66.2vh" class="d-flex align-items-center justify-content-center">
        Không tìm thấy sản phẩm
      </h1>
    </div>
  </div>
</template>

<script>
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import checkIcon from '@fortawesome/fontawesome-free-solid/faCheck';
import cartPlusIcon from '@fortawesome/fontawesome-free-solid/faCartPlus';
import solidFaHeart from '@fortawesome/fontawesome-free-solid/faHeart';
import regularFaHeart from '@fortawesome/fontawesome-free-regular/faHeart';
import facebookIcon from '@fortawesome/fontawesome-free-brands/faFacebookSquare';
import instagramIcon from '@fortawesome/fontawesome-free-brands/faInstagram';
import youtubeIcon from '@fortawesome/fontawesome-free-brands/faYoutube';
import googlePlusIcon from '@fortawesome/fontawesome-free-brands/faGooglePlus';
import { Carousel, Slide } from 'vue-carousel';
import SizeGuideDialog from './SizeGuideDialog';
import productService from '@/shared/services/product.service';
import categoryService from '@/shared/services/category.service';
import { priceFormat } from '@/filters';
import Spinner from '@/components/shared/spinner/Spinner';
import userProductCommunication from '@/shared/services/user-product-communication.service';
import { mapState, mapMutations } from 'vuex';

export default {
  components: {
    FontAwesomeIcon,
    Carousel,
    Slide,
    SizeGuideDialog,
    Spinner
  },
  filters: {
    priceFormat
  },
  data() {
    return {
      icons: {
        check: checkIcon,
        cart: cartPlusIcon,
        solidHeart: solidFaHeart,
        regularHeart: regularFaHeart,
        facebook: facebookIcon,
        instagram: instagramIcon,
        youtube: youtubeIcon,
        googlePlus: googlePlusIcon
      },
      product: {},
      isOpenSizeGuideDialog: false,
      recentlyViewedProducts: [],
      loading: true,
      selectedSize: {},
      breadcrumbs: [],
      category: {},
      relevantProducts: []
    };
  },
  computed: {
    ...mapState(['user']),
    id() {
      return this.$route.params.id;
    },
    color() {
      return this.$route.query.color;
    },
    heartIcon() {
      let heart;

      if (this.selectedselectedProduct.liked) {
        heart = solidFaHeart;
      } else {
        heart = regularFaHeart;
      }

      return {
        heart
      };
    },
    colors() {
      const colors = [];

      if (this.product.color) {
        colors.push(this.product.color);
      }
      if (this.product.sub_products) {
        this.product.sub_products.forEach(subProduct => {
          if (subProduct.color) {
            const existColor = colors.find(color => color.id === subProduct.color.id);

            if (!existColor) {
              colors.push(subProduct.color);
            }
          }
        });
      }

      return colors;
    },
    currentColor() {
      let color = this.colors.find(color => color.id === Number(this.$route.query.color));

      if (!color && this.colors.length) {
        color = this.colors[0];
      }

      return color;
    },
    sizes() {
      const sizes = [];

      if (this.currentColor) {
        if (this.product.size && this.product.color && this.product.color.id === this.currentColor.id) {
          const size = Object.assign({}, this.product.size);
          size.product = this.product;
          sizes.push(size);
        }

        this.product.sub_products.forEach(subProduct => {
          if (subProduct.size && subProduct.color && subProduct.color.id === this.currentColor.id) {
            const size = Object.assign({}, subProduct.size);
            size.product = subProduct;
            sizes.push(size);
          }
        });
      }

      return sizes;
    },
    images() {
      let images = [];

      this.sizes.some(size => {
        if (size.product.images && size.product.images.length) {
          images = size.product.images;
          return true;
        }
      });

      if (!images.length && this.product.images && this.product.images.length) {
        images.push(this.product.images[0]);
      }

      return images;
    },
    perPageCustom() {
      return [[768, 3], [1024, 4]];
    },
    selectedProduct() {
      if (this.sizes && this.sizes.length) {
        return this.sizes[0].product;
      }
      return this.product;
    },
    breadcrumbsLength() {
      return this.breadcrumbs.length;
    },
    categoryId() {
      if (this.selectedProduct && this.selectedProduct.category) {
        return this.selectedProduct.category.id;
      }
      return '';
    }
  },
  watch: {
    id(newValue) {
      this.onLoad();
    },
    categoryId(newValue) {
      this.getHierachyCategory(newValue);
    },
    category(newValue) {
      this.setBreadcrumbs(newValue);
      this.getRelevantProducts(this.id, newValue.id, 1);
    }
  },
  methods: {
    ...mapMutations('cart', {
      addProductToCart: 'add'
    }),
    toggleLiked() {
      if (this.user) {
        this.selectedProduct.liked = !this.selectedProduct.liked;
        if (this.selectedProduct.liked) {
          userProductCommunication.like(this.selectedProduct.id);
        } else {
          userProductCommunication.dislike(this.selectedProduct.id);
        }
      } else {
        alert('Hãy đăng nhập trước');
      }
    },
    getProduct(id) {
      return new Promise(resolve => {
        productService.getOne(id)
          .then(response => {
            if (response && response.status === 200 && response.data) {
              if (!response.data.id) {
                this.removeRecentlyViewedProduct(Number(this.$route.params.id));
              }

              this.product = response.data;
              resolve();
            }
          });
      });
    },
    selectColor(color) {
      this.goToProductPage(this.product, this.currentColor);
      this.formatRecentlyViewedProducts();
      this.scrollTop();
    },
    formatRecentlyViewedProducts() {
      let products = this.getRecentlyViewedProducts();

      if (products) {
        products = JSON.parse(products);
        this.recentlyViewedProducts = [];

        products.forEach(product => {
          if (product.id && product.id !== this.selectedProduct.id) {
            this.recentlyViewedProducts.push({
              id: product.id,
              images: product.images,
              color: product.color
            });
          }
        });
      }

      this.saveRecentlyViewedProducts();
    },
    getRecentlyViewedProducts() {
      const products = localStorage.getItem('recently_viewed');

      return products;
    },
    saveRecentlyViewedProducts() {
      const product = {};
      product.id = this.selectedProduct.id;
      product.images = this.images;
      product.color = this.currentColor;

      const products = JSON.parse(JSON.stringify(this.recentlyViewedProducts));
      products.unshift(product);

      localStorage.setItem('recently_viewed', JSON.stringify(products));
    },
    removeRecentlyViewedProduct(id) {
      let products = this.getRecentlyViewedProducts();

      if (products) {
        products = JSON.parse(products);

        for (const i of Object.keys(products)) {
          if (products[i].id === id) {
            products.splice(i, 1);
            break;
          }
        }
      }

      localStorage.setItem('recently_viewed', JSON.stringify(products));
    },
    goToProductPage(product, color) {
      const query = {};

      if (color) {
        query.color = color.id;
      }

      this.$router.push({name: 'Product', params: {id: product.id}, query});
    },
    async onLoad() {
      this.loading = true;
      this.scrollTop();
      this.recentlyViewedProducts = [];
      await this.getProduct(this.$route.params.id);
      this.formatRecentlyViewedProducts();
      this.loading = false;
    },
    scrollTop() {
      document.documentElement.scrollTo(0, 0);
    },
    getHierachyCategory(id) {
      categoryService.getHierachyCategory(id)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.category = response.data;
          }
        });
    },
    setBreadcrumbs(category) {
      let tmp = JSON.parse(JSON.stringify(this.category));
      this.setBreadcrumbs = [];

      while (tmp) {
        this.breadcrumbs.unshift({
          id: tmp.id,
          name: tmp.name
        });

        tmp = tmp.parent;
      }
    },
    selectSize(size) {
      this.selectedSize = size;
    },
    getRelevantProducts(id, categoryId, page = 1) {
      productService.getRelevant(id, categoryId, page)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.relevantProducts = response.data.data;
          }
        });
    }
  },
  created() {
    this.scrollTop();
  },
  mounted() {
    this.onLoad();
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.product-component {
  a {
    color: #212529;
  }
  .custom-select {
    cursor: pointer;
  }
  .color-list {
    .color-item {
      width: 25px;
      height: 25px;
      border: 2px solid #000;

      svg {
        font-size: 12px;
      }
    }
  }
  .cart {
    &.can-buy {
      height: 45px;
      background-color: #1d1e1e;
    }
    &:not(.can-buy) {
      pointer-events: none;
      color: #707070 !important;
      border: 1px solid #cecece;
      background-color: #eee;
    }
  }
  .like-button {
    width: 45px;
    height: 45px;
    font-size: 20px;
    border: 1px solid #1d1e1e;

    &:hover {
      color: #707070 !important;
    }
  }
  .info {
    color: #131313;
  }
  p {
    font-size: $font-size-sm;
  }
  .detail-button {
    font-size: $font-size-sm;
    color: #4d4d4d;

    &:hover {
      text-decoration: underline !important;
    }
  }
  .fa-instagram * {
    fill: url(#rg);
  }
  .recently-view-product {
    max-width: 50%;
  }
  .product-price {
    font-size: 1.1rem;
  }
  .size-item {
    width: 35px;
    height: 35px;
    font-size: .9rem;
    border: 1px solid #000;

    &.empty {
      cursor: auto;
      color: #ccc !important;
      border: none;
    }
    &:hover {
      border-width: 2px;
    }
    &.selected {
      color: #fff !important;
      background-color: #000;
    }
  }
  @media screen and (min-width: 768px) {
    .recently-view-product {
      max-width: calc(100% / 3) !important;
    }
  }
  @media screen and (min-width: 1024px) {
    .recently-view-product {
      max-width: 25% !important;
    }
  }
}
</style>
