<template>
  <div class="homepage">
    <nav class="navbar navbar-expand-lg justify-content-between py-3 px-2">
      <ul class="navbar-nav align-items-center breadcrumbs">
        <li class="nav-item">
          <a class="nav-link">MEN'S
          </a>
        </li> /
        <li class="nav-item">
          <a class="nav-link">All Clothing
          </a>
        </li> /
        <li class="nav-item">
          <a class="nav-link">T-Shirts
          </a>
        </li>
      </ul>
      <h3 class="text-uppercase font-weight-normal mb-0">Thời trang nam mùa hè</h3>
      <div></div>
    </nav>
    <hr class="bg-dark m-0" />
    <main-body></main-body>
  </div>
</template>

<script>
import MainBody from './main-body/MainBody';

export default {
  name: 'Homepage',
  components: {
    MainBody
  },
  data() {
    return {
    };
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';

  .homepage {
    background-color: #f8f7f7;

    .breadcrumbs {
      font-size: $font-size-sm;
    }
  }
</style>
