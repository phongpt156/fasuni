<template>
  <div class="lookbook">
    <p class="h5 text-center mb-0 py-4 text-uppercase">{{ title }}</p>
    <hr class="m-0" />
    <p class="text-center mb-0 py-3 description">Our collection. Styled our way. Every Month. Hover/Tap on a look you like to shop the items featured.</p>
    <!-- <div class="d-flex justify-content-center pb-3">
      <a class="view-archive-button py-2 px-3" @click="goToLookbookArchive">
        View Archive
      </a>
    </div> -->
    <div>
      <lookbook-list></lookbook-list>
    </div>
  </div>
</template>

<script>
import LookbookList from './lookbook-list/LookbookList';
import { GENDER } from '@/shared/constants';

export default {
  components: {
    LookbookList
  },
  data() {
    return {

    };
  },
  computed: {
    title() {
      let title = '';

      if (this.gender === GENDER.male.id) {
        title += 'Men\'s Lookbook // ';
      } else if (Number(this.gender) === GENDER.female.id) {
        title += 'Women\'s Lookbook // ';
      }
      title += `Tháng ${this.month} ${this.year}`;

      return title;
    },
    month() {
      return this.$route.params.month;
    },
    year() {
      return this.$route.params.year;
    },
    gender() {
      return this.$route.params.gender;
    }
  },
  methods: {
    goToLookbookArchive() {
      this.$router.push({name: 'LookbookArchive'});
    }
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.lookbook {
  min-height: calc(100vh - 322px);

  hr {
    border-top: 1px solid $black;
  }
  .description {
    color: #252525;
  }
  .view-archive-button {
    transition: all .3s ease-in-out 0s;
    border: 1px solid #4d4d4d;

    &:hover {
      color: $white !important;
      border-color: $black;
      background-color: $black;
    }
  }
}
</style>
