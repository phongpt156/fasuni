<template>
  <div class="homepage bg-white">
    <banner></banner>

    <div v-scroll-reveal.reset>
      <div class="p-5">
        <div class="row py-5">
          <div class="col-4 text-center">
            <img :src="images.gift" alt="" style="width: 56px; height: 57px" />
            <h6 class="font-weight-bold mt-3 mb-0">Free Shipping</h6>
            <p class="text-uppercase">All Order over $59</p>
          </div>
          <div class="col-4 text-center">
            <img :src="images.support" alt="" style="width: 56px; height: 57px" />
            <h6 class="font-weight-bold mt-3 mb-0">Support Customer</h6>
            <p class="text-uppercase">Support 24/7</p>
          </div>
          <div class="col-4 text-center">
            <img :src="images.lock" alt="" style="width: 56px; height: 57px" />
            <h6 class="font-weight-bold mt-3 mb-0">Secure Payments</h6>
            <p class="text-uppercase">Support 24/7</p>
          </div>
        </div>
      </div>
    </div>
    <div v-scroll-reveal.reset>
      <div class="row mx-0">
        <div class="pr-2 pl-3 col-md-4">
          <div class="pb-2 h-50">
            <a class="d-block h-100"><img :src="images.collection1" alt="" class="w-100 h-100" /></a>
          </div>
          <div class="pt-2 h-50">
            <a class="d-block h-100"><img :src="images.collection2" alt="" class="w-100 h-100" /></a>
          </div>
        </div>
        <div class="px-2 col-md-4">
          <a class="d-block h-100"><img :src="images.collection3" alt="" class="w-100 h-100" /></a>
        </div>
        <div class="pl-2 pr-3 col-md-4">
          <div class="pb-1 h-50">
            <a class="d-block h-100"><img :src="images.collection4" alt="" class="w-100 h-100" /></a>
          </div>
          <div class="pt-2 h-50">
            <a class="d-block h-100"><img :src="images.collection5" alt="" class="w-100 h-100" /></a>
          </div>
        </div>
      </div>
    </div>
    <div v-scroll-reveal.reset class="pt-5">
      <div class="py-5">
        <p class="mb-0 text-center text-uppercase font-weight-bold">Sản phẩm nổi bật</p>
        <hr class="mt-0 mx-2" />
        <carousel :perPageCustom="[[768, 3], [1024, 4]]" class="top-product px-5">
          <slide class="px-2">
            <div>
              <a class="d-block">
                <img :src="images.product1" alt="" class="w-100" />
              </a>
              <div class="text-center py-3 px-5 product-info">
                <p class="mb-0 text-uppercase">
                  Figure crew as long as you love me
                </p>
                <p class="font-weight-bold mb-0">450.000 đ</p>
              </div>
            </div>
          </slide>
          <slide class="px-2">
            <div>
              <a class="d-block">
                <img :src="images.product2" alt="" class="w-100" />
              </a>
              <div class="text-center py-3 px-5 product-info">
                <p class="mb-0 text-uppercase">
                  Figure crew as long as you love me
                </p>
                <p class="font-weight-bold mb-0">450.000 đ</p>
              </div>
            </div>
          </slide>
          <slide class="px-2">
            <div>
              <a class="d-block">
                <img :src="images.product3" alt="" class="w-100" />
              </a>
              <div class="text-center py-3 px-5 product-info">
                <p class="mb-0 text-uppercase">
                  Figure crew as long as you love me
                </p>
                <p class="font-weight-bold mb-0">450.000 đ</p>
              </div>
            </div>
          </slide>
          <slide class="px-2">
            <div>
              <a class="d-block">
                <img :src="images.product4" alt="" class="w-100" />
              </a>
              <div class="text-center py-3 px-5 product-info">
                <p class="mb-0 text-uppercase">
                  Figure crew as long as you love me
                </p>
                <p class="font-weight-bold mb-0">450.000 đ</p>
              </div>
            </div>
          </slide>
        </carousel>
      </div>
    </div>
    <div v-scroll-reveal.reset>
      <a>
        <div class="image-wrapper image-15-4">
          <img :src="images.subBanner" alt="" />
        </div>
      </a>
    </div>
    <div v-scroll-reveal.reset class="pt-5">
      <div class="py-5">
        <p class="mb-0 text-center text-uppercase font-weight-bold">Các bài viết</p>
        <hr class="mt-0 mx-2" />
        <carousel :perPageCustom="[[768, 1], [1024, 2]]" class="px-5 pt-3">
          <slide class="px-3">
            <div class="post-item">
              <a class="d-block image-wrapper image-21-9">
                <img :src="images.post1" alt="" class="w-100" />
              </a>
              <div class="py-3 px-5 post-info">
                <p class="mb-0" style="color: #c4c4c4">Life style</p>
                <h6 class="mb-0 text-uppercase font-weight-bold">
                  Get Ready for Pink Pantsuit Nation
                </h6>
                <a class="d-block read-more mt-3 font-weight-bold">Đọc tiếp</a>
              </div>
            </div>
          </slide>
          <slide class="px-3">
            <div class="post-item">
              <a class="d-block image-wrapper image-21-9">
                <img :src="images.post2" alt="" class="w-100" />
              </a>
              <div class="py-3 px-5 post-info">
                <p class="mb-0" style="color: #c4c4c4">Life style</p>
                <h6 class="mb-0 text-uppercase font-weight-bold">
                  Get Ready for Pink Pantsuit Nation
                </h6>
                <a class="d-block read-more mt-3 font-weight-bold">Đọc tiếp</a>
              </div>
            </div>
          </slide>
        </carousel>
      </div>
    </div>
    <div v-scroll-reveal.reset class="pt-5 companion">
      <div class="py-5">
        <p class="mb-0 text-center text-uppercase font-weight-bold ">Nhà đồng hành</p>
        <hr class="mt-0 mx-2" />
        <div class="d-flex">
          <div class="px-5" style="flex-grow: 1">
            <a class="d-block image-wrapper image-1-1" href="https://mayphuongthao.com/" target="_blank">
              <img src="https://mayphuongthao.com/wp-content/uploads/2017/09/logo-mayphuongthao.png" alt="" />
            </a>
          </div>
          <div class="px-5" style="flex-grow: 1">
            <a class="d-block image-wrapper image-1-1">
              <img :src="images.company1" alt="" />
            </a>
          </div>
          <div class="px-5" style="flex-grow: 1">
            <a class="d-block image-wrapper image-1-1">
              <img :src="images.company2" alt="" />
            </a>
          </div>
          <div class="px-5" style="flex-grow: 1">
            <a class="d-block image-wrapper image-1-1">
              <img :src="images.company3" alt="" />
            </a>
          </div>
          <div class="px-5" style="flex-grow: 1">
            <a class="d-block image-wrapper image-1-1">
              <img :src="images.company4" alt="" />
            </a>
          </div>
          <div class="px-5" style="flex-grow: 1">
            <a class="d-block image-wrapper image-1-1">
              <img :src="images.company5" alt="" />
            </a>
          </div>
          <div class="px-5" style="flex-grow: 1">
            <a class="d-block image-wrapper image-1-1">
              <img :src="images.company6" alt="" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';
import Banner from './Banner';
import gift from '@/assets/images/gift.png';
import lock from '@/assets/images/lock.png';
import support from '@/assets/images/support.png';
import collection1 from '@/assets/images/collection1.jpg';
import collection2 from '@/assets/images/collection2.jpg';
import collection3 from '@/assets/images/collection3.jpg';
import collection4 from '@/assets/images/collection4.jpg';
import collection5 from '@/assets/images/collection5.jpg';
import product1 from '@/assets/images/product1.jpg';
import product2 from '@/assets/images/product2.jpg';
import product3 from '@/assets/images/product3.jpg';
import product4 from '@/assets/images/product4.jpg';
import subBanner from '@/assets/images/sub-banner.jpg';
import post1 from '@/assets/images/post1.jpg';
import post2 from '@/assets/images/post2.jpg';
import company1 from '@/assets/images/company1.jpg';
import company2 from '@/assets/images/company2.jpg';
import company3 from '@/assets/images/company3.jpg';
import company4 from '@/assets/images/company4.jpg';
import company5 from '@/assets/images/company5.jpg';
import company6 from '@/assets/images/company6.jpg';

export default {
  components: {
    Carousel,
    Slide,
    Banner
  },
  name: 'Homepage',
  data() {
    return {
      images: {
        gift,
        lock,
        support,
        collection1,
        collection2,
        collection3,
        collection4,
        collection5,
        product1,
        product2,
        product3,
        product4,
        subBanner,
        post1,
        post2,
        company1,
        company2,
        company3,
        company4,
        company5,
        company6
      }
    };
  },
  created() {
    document.documentElement.scrollTo(0, 0);
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.homepage {
  background-color: #f8f7f7;

  .breadcrumbs {
    position: absolute;
    left: 0.5rem;
    font-size: $font-size-sm;
  }

  hr {
    border-top: 1px solid $black;
  }

  .top-product {
    font-size: $font-size-sm;

    .VueCarousel-slide {
      &:hover {
        .product-info {
          border-top: unset !important;
          border: 1px solid #b7b7b7;
        }
      }
    }
  }
  .post-item {
    &:hover {
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .post-info {
      border-top: unset !important;
      border: 2px solid #636363;
    }
    .read-more {
      &:hover {
        text-decoration: underline;
      }
    }
  }
  .companion {
    img {
      object-fit: contain;
    }
  }
}
</style>
