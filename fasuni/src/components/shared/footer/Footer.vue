<template>
  <footer class="footer p-5">
    <div class="row align-items-start">
      <div class="col-md-3">
        <a class="branding-name text-white" @click="goToHomepage">
          Fasuni
        </a>
      </div>
      <div class="col-md-3 d-flex flex-column about-us">
        <p class="font-weight-bold text-uppercase text-white mt-3">Về chúng tôi</p>
        <a>Liên hệ</a>
        <a>Sitemap</a>
        <a>Stores</a>
        <a>Login</a>
        <a>My account</a>
      </div>
      <div class="col-md-3 d-flex flex-column shop-guilde">
        <p class="font-weight-bold text-uppercase text-white mt-3">Shop Guide</p>
        <a>Delivery</a>
        <a>Legal Notice</a>
        <a>Terms And Conditions</a>
        <a>About Us</a>
        <a>Secure Payment</a>
      </div>
      <div class="col-md-3 d-flex flex-column">
        <p class="font-weight-bold text-uppercase text-white mt-3">Đăng ký tư vấn</p>
        <p class="mb-0 text-uppercase text-white font-size-sm">Gửi thông tin cho chúng tôi</p>
        <form class="form-inline search-form py-2">
          <input class="form-control text-dark" />
          <button class="btn my-2 my-sm-0 text-white" type="button">Gửi</button>
        </form>
        <div class="d-flex social">
          <a class="mx-2">
            <font-awesome-icon :icon="icons.facebook"></font-awesome-icon>
          </a>
          <a class="mx-2">
            <font-awesome-icon :icon="icons.instagram"></font-awesome-icon>
          </a>
          <a class="mx-2">
            <font-awesome-icon :icon="icons.youtube"></font-awesome-icon>
          </a>
          <a class="mx-2">
            <font-awesome-icon :icon="icons.googlePlus"></font-awesome-icon>
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import facebookIcon from '@fortawesome/fontawesome-free-brands/faFacebookSquare';
import instagramIcon from '@fortawesome/fontawesome-free-brands/faInstagram';
import youtubeIcon from '@fortawesome/fontawesome-free-brands/faYoutube';
import googlePlusIcon from '@fortawesome/fontawesome-free-brands/faGooglePlus';

export default {
  components: {
    FontAwesomeIcon
  },
  data() {
    return {
      icons: {
        facebook: facebookIcon,
        instagram: instagramIcon,
        youtube: youtubeIcon,
        googlePlus: googlePlusIcon
      }
    };
  },
  methods: {
    goToHomepage() {
      this.$router.push({name: 'Homepage'});
    }
  }
};
</script>

<style lang="scss">
.footer {
  color: #b9b9b9;
  background-color: #111111;

  .about-us, .shop-guilde {
    a {
      &:hover {
        text-decoration: underline !important;
      }
    }
  }
  .social {
    font-size: 23px;

    svg {
      color: #b9b9b9;

      &:hover {
        color: #fff;
      }
    }
  }
}
</style>
