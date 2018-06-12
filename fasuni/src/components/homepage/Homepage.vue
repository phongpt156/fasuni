<template>
  <div class="homepage bg-white">
    <banner></banner>

    <div v-scroll-reveal.reset class="pt-5">
      <div class="row mx-0 px-5 pt-5">
        <div class="px-5 col-md-4">
          <div class="collection-item">
            <a class="d-block h-100 image-wrapper image-2-3"><img :src="images.collection1" alt="" class="w-100 h-100" /></a>
            <div class="name">
              <div class="d-flex align-items-center justify-content-center h-100">
                <p class="text-center text-uppercase mt-3" style="font-size: 1.5rem">Campaign</p>
              </div>
            </div>
          </div>
        </div>
        <div class="px-5 col-md-4">
          <div class="collection-item">
            <a class="d-block h-100 image-wrapper image-2-3"><img :src="images.collection3" alt="" class="w-100 h-100" /></a>
            <div class="name">
              <div class="d-flex align-items-center justify-content-center h-100">
                <p class="text-center text-uppercase mt-3" style="font-size: 1.5rem">Shop Men</p>
              </div>
            </div>
          </div>
        </div>
        <div class="px-5 col-md-4">
          <div class="collection-item">
            <a class="d-block h-100 image-wrapper image-2-3"><img :src="images.collection2" alt="" class="w-100 h-100" /></a>
            <div class="name">
              <div class="d-flex align-items-center justify-content-center h-100">
                <p class="text-center text-uppercase mt-3" style="font-size: 1.5rem">Shop women</p>
              </div>
            </div>
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
              <router-link class="d-block" :to="{name: 'Product', params: {id: 226}}">
                <img src="https://cdn-images.kiotviet.vn/fasuni/e6a2cce47e2b408f89698194da7533bd" alt="" class="w-100" />
              </router-link>
              <div class="text-center py-3 px-5 product-info">
                <p class="mb-0 text-uppercase">
                  THẮT LƯNG TL-003
                </p>
                <p class="font-weight-bold mb-0">800,000 VNĐ</p>
              </div>
            </div>
          </slide>
          <slide class="px-2">
            <div>
              <router-link class="d-block" :to="{name: 'Product', params: {id: 225}}">
                <img src="https://cdn-images.kiotviet.vn/fasuni/e85ab49cb8794efe9f11d3d68ea08232" alt="" class="w-100" />
              </router-link>
              <div class="text-center py-3 px-5 product-info">
                <p class="mb-0 text-uppercase">
                  THẮT LƯNG TL-004
                </p>
                <p class="font-weight-bold mb-0">800,000 VNĐ</p>
              </div>
            </div>
          </slide>
          <slide class="px-2">
            <div>
              <router-link class="d-block" :to="{name: 'Product', params: {id: 49}, query: {color: 9}}">
                <img src="https://cdn-images.kiotviet.vn/fasuni/b4fae2fe372d462fb5001025bd4d2f9a" alt="" class="w-100" />
              </router-link>
              <div class="text-center py-3 px-5 product-info">
                <p class="mb-0 text-uppercase">
                  GIÀY CÁ SẤU GD-02-41
                </p>
                <p class="font-weight-bold mb-0">3,600,000 VNĐ</p>
              </div>
            </div>
          </slide>
          <slide class="px-2">
            <div>
              <router-link class="d-block" :to="{name: 'Product', params: {id: 45}, query: {color: 21}}">
                <img src="https://cdn-images.kiotviet.vn/fasuni/f66bd986d9364b3ebeabd9d296913ea0" alt="" class="w-100" />
              </router-link>
              <div class="text-center py-3 px-5 product-info">
                <p class="mb-0 text-uppercase">
                  GIÀY DA NÂU GD-01-41
                </p>
                <p class="font-weight-bold mb-0">3,600,000 VNĐ</p>
              </div>
            </div>
          </slide>
        </carousel>
      </div>
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
      <a>
        <div class="image-wrapper image-15-4">
          <img :src="images.subBanner" alt="" />
        </div>
      </a>
    </div>
    <div v-scroll-reveal.reset class="pt-5 companion">
      <div class="py-5">
        <p class="mb-0 text-center text-uppercase font-weight-bold ">Nhà đồng hành</p>
        <hr class="mt-0 mx-2" />
        <div class="d-flex">
          <div class="px-5" style="flex-grow: 1; max-width: 15%">
            <a class="d-block image-wrapper image-1-1" href="https://mayphuongthao.com/" target="_blank">
              <img src="https://mayphuongthao.com/wp-content/uploads/2017/09/logo-mayphuongthao.png" alt="" />
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
import collection1 from '@/assets/images/CEF_9071.jpg';
import collection2 from '@/assets/images/34415303_956348787872455_5434430696678490112_n.jpg';
import collection3 from '@/assets/images/34530408_956364091204258_7630724324420222976_n.jpg';
import subBanner from '@/assets/images/paper-flamingo.jpg';
import post1 from '@/assets/images/post1.jpg';
import post2 from '@/assets/images/post2.jpg';

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
        subBanner,
        post1,
        post2
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
  .collection-item {
    position: relative;

    &:hover {
      &:after {
        transition: opacity .15s ease 0s;
        opacity: 1;
      }

      .name {
        transform: scale(1);
        opacity: 1;
      }
    }

    &:after {
      width: 100%;
      top: 0;
      transition: opacity .2s ease .2s;
      position: absolute;
      opacity: 0;
      left: 0;
      height: 100%;
      display: block;
      content: "";
      background: none repeat scroll 0 0 rgba(0, 0, 0, 0.35);
    }

    .name {
      z-index: 1000;
      top: 0;
      transition: all linear .2s;
      transform: scale(0.8);
      right: -1px;
      position: absolute;
      overflow: hidden;
      opacity: 0;
      left: 0;
      color: rgba(255, 255, 255, .8);
      bottom: -1px;

      p {
        color: hsla(0, 0%, 100%, .8);

        &:hover {
          color: $white;
        }
      }
    }
  }
}
</style>
