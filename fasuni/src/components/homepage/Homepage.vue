<template>
  <div class="homepage">
    <div class="banner">
      <img src="https://images.allsaints.com/static/1600/120418-THE-HAWAIIAN-PROJECT-HP.jpg" alt="" class="w-100" />
    </div>

    <div v-scroll-reveal.reset>
      <div class="row mx-0" style="margin-top: 80px">
        <div class="col-md-6">
          <div class="w-75 m-auto">
            <a>
              <img src="https://images.allsaints.com/static/1600/120418-APRIL-LB-LEATHERS-WW-V2.jpg" alt="" class="img-fluid" />
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="w-75 m-auto">
            <a>
              <img src="https://images.allsaints.com/static/1600/120418-APRIL-LB-TSHIRTS-MW-V2.jpg" alt="" class="img-fluid" />
            </a>
          </div>
        </div>
      </div>
    </div>
    <div v-scroll-reveal.reset>
      <div class="row mx-0" style="margin-top: 80px">
        <div class="col-md-6">
          <div class="w-75 m-auto">
            <a>
              <img src="https://images.allsaints.com/static/1600/120418-APRIL-LB-JACKETS-MW-V2.jpg" alt="" class="img-fluid" />
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="w-75 m-auto">
            <a>
              <img src="https://images.allsaints.com/static/1600/120418-APRIL-LB-T-SHIRTS-WW-V2.jpg" alt="" class="img-fluid" />
            </a>
          </div>
        </div>
      </div>
    </div>
    <div v-scroll-reveal.reset>
      <div class="my-5">
        <p class="mb-0 text-center text-uppercase">Sản phẩm nổi bật</p>
        <hr class="mt-0 mx-2" />
        <carousel :perPageCustom="[[768, 3], [1024, 4]]">
          <slide class="px-2">
            <a class="d-block">
              <img src="http://pnf.vn/wp-content/uploads/2018/03/QSD.075-4-285x342.jpg" alt="" class="w-100" />
            </a>
          </slide>
          <slide class="px-2">
            <a class="d-block">
              <img src="http://pnf.vn/wp-content/uploads/2018/03/AVL.304-4-285x342.jpg" alt="" class="w-100" />
            </a>
          </slide>
          <slide class="px-2">
            <a class="d-block">
              <img src="http://pnf.vn/wp-content/uploads/2018/03/AVL.303-5-285x342.jpg" alt="" class="w-100" />
            </a>
          </slide>
          <slide class="px-2">
            <a class="d-block">
              <img src="http://pnf.vn/wp-content/uploads/2018/03/QVL.304-2-285x342.jpg" alt="" class="w-100" />
            </a>
          </slide>
        </carousel>
      </div>
    </div>
  </div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
  components: {
    Carousel,
    Slide
  },
  name: 'Homepage',
  data() {
    return {
    };
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
  }
</style>
