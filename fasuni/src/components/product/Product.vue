<template>
  <div class="px-2 product-component">
    <ul class="navbar-nav align-items-center flex-row pt-4 pb-2 d-md-flex d-none">
      <li class="nav-item">
        <a class="nav-link p-2">MEN'S
        </a>
      </li> /
      <li class="nav-item">
        <a class="nav-link p-2">All Clothing
        </a>
      </li> /
      <li class="nav-item">
        <a class="nav-link p-2">Áo mùa hè
        </a>
      </li> /
      <li class="nav-item">
        <a class="nav-link p-2">Áo sơ mi
        </a>
      </li>
    </ul>
    <div>
      <div class="row m-0">
        <div class="col-md-8 p-0">
          <div class="row m-0">
            <div class="col-sm-6 p-2">
              <img src="https://images.allsaints.com/products/900/WL047C/140/WL047C-140-1.jpg" alt="" class="img-fluid" />
            </div>
            <div class="col-sm-6 p-2">
              <img src="https://images.allsaints.com/products/900/WL047C/140/WL047C-140-2.jpg" alt="" class="img-fluid" />
            </div>
            <div class="col-sm-6 p-2">
              <img src="https://images.allsaints.com/products/900/WL047C/140/WL047C-140-3.jpg" alt="" class="img-fluid" />
            </div>
            <div class="col-sm-6 p-2">
              <img src="https://images.allsaints.com/products/900/WL047C/140/WL047C-140-4.jpg" alt="" class="img-fluid" />
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="text-danger mt-2 font-weight-bold mb-4" style="line-height: normal">HOT</div>
          <div class="text-uppercase h4 mb-4">Tassel Balfern Biker</div>
          <div class="h4 mb-4">620.000 VNĐ</div>
          <div class="d-flex color-list mb-3">
            <a style="background-color: #000000" class="mr-2 color-item d-flex align-items-center justify-content-center"><font-awesome-icon class="text-white" :icon="icons.check"></font-awesome-icon></a>
            <a style="background-color: #e96504" class="mr-2 color-item"></a>
            <a style="background-color: #00a651" class="color-item"></a>
          </div>
          <select class="custom-select my-4" style="width: 106px">
            <option>Size XS</option>
            <option value="1" selected="selected">Size S</option>
            <option value="2">Size M</option>
            <option value="3">Size L</option>
            <option value="4">Size XL</option>
            <option value="5">Size XXL</option>
          </select>
          <div class="d-flex mt-2">
            <a class="mr-3 d-inline-flex align-items-center justify-content-center text-white cart px-4 py-2">
              <font-awesome-icon :icon="icons.cart" class="mr-2"></font-awesome-icon>
              <span class="mt-1 font-size-sm">Thêm vào giỏ</span>
            </a>
            <a
              class="d-inline-flex align-items-center justify-content-center like-button"
              @click="toggleIsLiked">
              <font-awesome-icon
                :icon="icons.solidHeart"
                v-if="product.isLiked"></font-awesome-icon>
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
          <p class="mb-0 text-uppercase font-size-base"><a>Size Guide</a></p>
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
          <p class="mb-2">Share your Fasuni look using #FASUNI or upload <u>here</u> to be featured on fasuni.vn</p>
          <p class="mb-0 text-uppercase">#Fasuni</p>
        </div>
      </div>
    </div>
    <div class="mt-5">
      <p class="mb-0 text-center text-uppercase">Có thể bạn sẽ thích</p>
      <hr class="mt-0 mx-2" />
      <carousel :perPageCustom="[[768, 3], [1024, 4]]">
        <slide class="px-2">
          <a class="d-block">
            <img src="https://images.allsaints.com/products/600/WL115E/5/WL115E-5-1.jpg" alt="" class="img-fluid" />
          </a>
          <p class="font-size-base text-upper-case my-1">Figure Crew As Long As You Love Me</p>
          <p class="mb-1">Our new Grace Zip Jeans Are Crafted from premium stretch den...</p>
          <a class="detail-button">Chi tiết >></a>
        </slide>
        <slide class="px-2">
          <a class="d-block">
            <img src="https://images.allsaints.com/products/600/WL333N/5335/WL333N-5335-1.jpg" alt="" class="img-fluid" />
          </a>
          <p class="font-size-base text-upper-case my-1">Figure Crew As Long As You Love Me</p>
          <p class="mb-1">Our new Grace Zip Jeans Are Crafted from premium stretch den...</p>
          <a class="detail-button">Chi tiết >></a>
        </slide>
        <slide class="px-2">
          <a class="d-block">
            <img src="https://images.allsaints.com/products/600/WL047C/140/WL047C-140-1.jpg" alt="" class="img-fluid" />
          </a>
          <p class="font-size-base text-upper-case my-1">Figure Crew As Long As You Love Me</p>
          <p class="mb-1">Our new Grace Zip Jeans Are Crafted from premium stretch den...</p>
          <a class="detail-button">Chi tiết >></a>
        </slide>
        <slide class="px-2">
          <a class="d-block">
            <img src="https://images.allsaints.com/products/600/WL027N/226/WL027N-226-1.jpg" alt="" class="img-fluid" />
          </a>
          <p class="font-size-base text-upper-case my-1">Figure Crew As Long As You Love Me</p>
          <p class="mb-1">Our new Grace Zip Jeans Are Crafted from premium stretch den...</p>
          <a class="detail-button">Chi tiết >></a>
        </slide>
      </carousel>
    </div>
    <div class="my-5">
      <p class="mb-0 text-center text-uppercase">Xem gần đây</p>
      <hr class="mt-0 mx-2" />
      <carousel :perPageCustom="[[768, 3], [1024, 4]]">
        <slide class="px-2">
          <a class="d-block">
            <img src="https://images.allsaints.com/products/600/WL115E/5/WL115E-5-1.jpg" alt="" class="img-fluid" />
          </a>
        </slide>
        <slide class="px-2">
          <a class="d-block">
            <img src="https://images.allsaints.com/products/600/WL333N/5335/WL333N-5335-1.jpg" alt="" class="img-fluid" />
          </a>
        </slide>
        <slide class="px-2">
          <a class="d-block">
            <img src="https://images.allsaints.com/products/600/WL047C/140/WL047C-140-1.jpg" alt="" class="img-fluid" />
          </a>
        </slide>
        <slide class="px-2">
          <a class="d-block">
            <img src="https://images.allsaints.com/products/600/WL027N/226/WL027N-226-1.jpg" alt="" class="img-fluid" />
          </a>
        </slide>
      </carousel>
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

export default {
  components: {
    FontAwesomeIcon,
    Carousel,
    Slide
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
      product: {
        isLiked: false
      }
    };
  },
  computed: {
    heartIcon() {
      let heart;

      if (this.product.isLiked) {
        heart = solidFaHeart;
      } else {
        heart = regularFaHeart;
      }

      return {
        heart
      };
    }
  },
  methods: {
    toggleIsLiked() {
      this.product.isLiked = !this.product.isLiked;
    }
  }
};
</script>

<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';

  .product-component {
    .color-list {
      .color-item {
        width: 25px;
        height: 25px;

        svg {
          font-size: 12px;
        }
      }
    }
    .cart {
      height: 45px;
      background-color: #1d1e1e;
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
    .font-size-base {
      font-size: $font-size-base;
    }
    .font-size-sm {
      font-size: $font-size-sm;
    }
    .detail-button {
      font-size: $font-size-sm;
      color: #4d4d4d;

      &:hover {
        text-decoration: underline !important;
      }
    }
    .VueCarousel-pagination {
      display: none;
    }
    .fa-instagram * {
      fill: url(#rg);
    }
  }
</style>
