<template>
  <div class="sidenav-overlay">
    <vue-perfect-scrollbar class="py-4" style="height: 100vh">
      <div class="sidenav-overlay--inner">
        <font-awesome-icon :icon="icons.times" class="close-button" @click="$emit('close')"></font-awesome-icon>
        <div class="category-list pt-5">
          <div
            v-for="category in categories"
            :key="category.id"
            class="category-item d-block">
            <a
              class="p-3 d-flex justify-content-between category-link"
              @click="toggleCollapsed(category)"
              data-toggle="collapse"
              :data-target="`.category-${category.id}`"
              :class="{'custom-background': category.children && category.children.length && !category.collapsed}">
              {{ category.name }}
              <span v-if="category.children && category.children.length">
                <font-awesome-icon :icon="icons.plus" v-if="category.collapsed"></font-awesome-icon>
                <font-awesome-icon :icon="icons.minus" v-else></font-awesome-icon>
              </span>
            </a>
            <div class="collapse" :class="`category-${category.id}`">
              <template v-if="category.children">
                <div v-for="children in category.children" :key="children.id">
                  <a
                    class="p-3 pl-4 d-flex justify-content-between category-link"
                    @click="toggleCollapsed(children)"
                    data-toggle="collapse"
                    :data-target="`.category-${children.id}`"
                    :class="{'custom-background': children.children && children.children.length && !children.collapsed}">
                    {{ children.name }}
                    <span v-if="children.children && children.children.length">
                      <font-awesome-icon :icon="icons.plus" v-if="children.collapsed"></font-awesome-icon>
                      <font-awesome-icon :icon="icons.minus" v-else></font-awesome-icon>
                    </span>
                  </a>
                  <div class="collapse" :class="`category-${children.id}`">
                    <template v-if="children.children">
                      <router-link
                        v-for="children1 in children.children" :key="children1.id"
                        class="p-3 pl-5 d-flex justify-content-between category-link"
                        :to="{name: 'Category', params: {id: children1.id}}">{{ children1.name }}
                      </router-link>
                    </template>
                  </div>
                </div>
              </template>
            </div>
          </div>
          <div class="category-item d-block">
            <a
              class="p-3 d-flex justify-content-between category-link"
              @click="toggleCollapsed(lookbookMonthList)"
              data-toggle="collapse"
              data-target=".lookbook-collapse">
              Studio
              <span>
                <font-awesome-icon :icon="icons.plus" v-if="lookbookMonthList.collapsed"></font-awesome-icon>
                <font-awesome-icon :icon="icons.minus" v-else></font-awesome-icon>
              </span>
            </a>
            <div class="collapse lookbook-collapse">
              <div>
                <a
                  class="p-3 pl-4 d-flex justify-content-between category-link"
                  @click="lookbookMonthList.femaleCollapsed = !lookbookMonthList.femaleCollapsed"
                  data-toggle="collapse"
                  data-target=".women-lookbook"
                  :class="{'custom-background': !lookbookMonthList.femaleCollapsed}">
                  Women's Lookbook
                  <span>
                    <font-awesome-icon :icon="icons.plus" v-if="lookbookMonthList.femaleCollapsed"></font-awesome-icon>
                    <font-awesome-icon :icon="icons.minus" v-else></font-awesome-icon>
                  </span>
                </a>
                <div class="collapse women-lookbook">
                  <router-link
                    v-for="(month, index) in lookbookMonthList.female" :key="index"
                    class="p-3 pl-5 d-flex justify-content-between category-link"
                    :to="{name: 'Lookbook', params: {gender: genders.female.id, year: month.year, month: month.month}}">Tháng {{ month.month }}
                  </router-link>
                </div>
              </div>
              <div>
                <a
                  class="p-3 pl-4 d-flex justify-content-between category-link"
                  @click="lookbookMonthList.maleCollapsed = !lookbookMonthList.maleCollapsed"
                  data-toggle="collapse"
                  data-target=".men-lookbook"
                  :class="{'custom-background': !lookbookMonthList.maleCollapsed}">
                  Men's Lookbook
                  <span>
                    <font-awesome-icon :icon="icons.plus" v-if="lookbookMonthList.maleCollapsed"></font-awesome-icon>
                    <font-awesome-icon :icon="icons.minus" v-else></font-awesome-icon>
                  </span>
                </a>
                <div class="collapse men-lookbook">
                  <router-link
                    v-for="(month, index) in lookbookMonthList.male" :key="index"
                    class="p-3 pl-5 d-flex justify-content-between category-link"
                    :to="{name: 'Lookbook', params: {gender: genders.male.id, year: month.year, month: month.month}}">Tháng {{ month.month }}
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>

        <search-form class="my-2 px-3"></search-form>
        <router-link class="p-3 d-flex justify-content-between category-link" :to="{name: 'StoreFinder'}">
          Cửa hàng
        </router-link>
        <router-link class="p-3 d-flex justify-content-between category-link" :to="{name: 'Cart'}">
          Giỏ hàng
        </router-link>
        <div>
          <a v-if="user" id="userDropdownMobile" data-toggle="dropdown" class="p-3 d-flex justify-content-between category-link">
            {{ userName }}
            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="userDropdownMobile">
              <a class="dropdown-item">My Wishlist</a>
              <a class="dropdown-item" @click="logout">Đăng xuất</a>
            </div>
          </a>
          <a class="d-flex p-3 category-item category-link" @click="$emit('openLoginForm')" v-else>
            Sign in
          </a>
        </div>
      </div>
    </vue-perfect-scrollbar>
  </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { mapState, mapMutations } from 'vuex';
import { reloadApp } from '@/shared/functions';
import VuePerfectScrollbar from 'vue-perfect-scrollbar';
import timesIcon from '@fortawesome/fontawesome-free-solid/faTimes';
import plusIcon from '@fortawesome/fontawesome-free-solid/faPlus';
import minusIcon from '@fortawesome/fontawesome-free-solid/faMinus';
import userService from '@/shared/services/user.service';
import SearchForm from './../search-form/SearchForm';

export default {
  props: {
    categories: {
      type: Array,
      default() {
        return [];
      },
    },
    lookbookMonthList: {
      type: Object,
      default() {
        return {};
      },
    },
    genders: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  components: {
    SearchForm,
    FontAwesomeIcon,
    VuePerfectScrollbar,
  },
  data() {
    return {
      icons: {
        times: timesIcon,
        plus: plusIcon,
        minus: minusIcon,
      },
    };
  },
  computed: {
    ...mapState(['user']),
    userName() {
      if (this.user.facebook_name) {
        return this.user.facebook_name;
      }
      if (this.user.name) {
        return this.user.name;
      }
      return `${this.user.first_name} ${this.user.last_name}`;
    },
  },
  methods: {
    setToggleableCategories(categories) {
      categories.forEach(category => {
        if (category.children && category.children.length) {
          this.$set(category, 'collapsed', true);
          this.setToggleableCategories(category.children);
        }
      });
    },
    toggleCollapsed(category) {
      if (category.children && category.children.length) {
        category.collapsed = !category.collapsed;
      }
    },
    ...mapMutations('auth', [
      'removeToken',
    ]),
    openRegisterFormDialog() {
      this.isOpenLoginFormDialog = false;
      this.isOpenRegisterFormDialog = true;
    },
    openLoginFormDialog() {
      this.isOpenLoginFormDialog = true;
      this.isOpenRegisterFormDialog = false;
    },
    logout() {
      userService.logout();
      this.removeToken();
      reloadApp();
    },
  },
  mounted() {
    this.setToggleableCategories(this.categories);
  },
};
</script>

<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';
  @import '~bootstrap/scss/bootstrap-grid';

  .sidenav-overlay {
    z-index: 9997;
    transition: all .3s ease;
    top: 0;
    right: 0;
    position:fixed;
    height: 100%;
    font-size: $font-size-base;
    color: #818181;
    background-color: #111;

    &--inner {
      position: relative;

      .close-button {
        top: 0;
        right: 1rem;
        position: absolute;
        cursor: pointer;

        &:hover {
          color: $white;
        }
      }
    }
    .category-link {
      color: #818181;

      &:hover {
        text-decoration: none;
        background-color: #303030;
      }
      &.custom-background {
        background-color: #303030;
      }
    }
    .dropdown-menu {
      background-color: #ddd;

      .dropdown-item {
        &:active, &:hover {
          background-color: #989b9f;
        }
      }
    }
  }

  @include media-breakpoint-up(lg) {
    .sidenav-overlay {
      display: none;
    }
  }
</style>
