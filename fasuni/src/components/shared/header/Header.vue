<template>
  <header class="header fixed-top shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light">
      <img :src="images.icon" alt="" style="width: 60px; height: 60px; position: absolute; left: 47.5%; top: -2px" class="d-xl-block d-none" />
      <router-link class="navbar-brand branding-name h-100 d-flex align-items-center mt-0" :to="{name: 'Homepage'}">Fasuni</router-link>
      <search-form v-if="!isLargeScreen"></search-form>
      <button class="navbar-toggler" type="button" @click="isOpenSidenavOverlay = !isOpenSidenavOverlay">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto align-items-center category-list">
          <li
            class="nav-item dropdown h-100 d-flex align-items-center"
            v-for="category in categories"
            :key="category.id">
            <router-link class="nav-link text-uppercase text-dark"
              :to="{name: 'Category', params: {id: category.id}}">{{ category.name }}
            </router-link>
            <div class="dropdown-menu mt-0 p-4 shadow-sm">
              <div class="dropdown-item px-5">
                <ul class="navbar-nav sub-nav pr-5 d-inline-flex" v-for="category in category.children" :key="category.id">
                  <li>
                    <router-link class="h6 mb-3 d-inline-block font-weight-bold category-item"
                      :to="{name: 'Category', params: {id: category.id}}">{{ category.name }}
                    </router-link>
                    <ul class="navbar-nav flex-column flex-wrap" v-if="category.children.length">
                      <li v-for="category in category.children" :key="category.id" class="mr-4 my-1">
                        <router-link class="category-item"
                          :to="{name: 'Category', params: {id: category.id}}">{{ category.name }}
                        </router-link>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown h-100 d-flex align-items-center">
            <a class="nav-link text-uppercase text-dark" data-toggle="dropdown">
              Studio
            </a>
            <div class="dropdown-menu mt-0 p-4 shadow-sm">
              <div class="dropdown-item px-5">
                <ul class="navbar-nav sub-nav pr-5 d-inline-flex">
                  <li class="mr-4 my-1">
                    <a class="h6 mb-3 d-block font-weight-bold" style="font-size: .875rem">Women's Lookbook</a>
                    <ul class="navbar-nav flex-column flex-wrap" v-if="lookbookMonthList.female.length">
                      <li v-for="(month, index) in lookbookMonthList.female" :key="index" class="mr-4 my-1">
                        <router-link class="category-item"
                          :to="{name: 'Lookbook', params: {gender: genders.female.id, year: month.year, month: month.month}}">Tháng {{ month.month }}
                        </router-link>
                      </li>
                    </ul>
                  </li>
                  <li class="mr-4 my-1">
                    <a class="h6 mb-3 d-block font-weight-bold" style="font-size: .875rem">Men's Lookbook</a>
                    <ul class="navbar-nav flex-column flex-wrap" v-if="lookbookMonthList.male.length">
                      <li v-for="(month, index) in lookbookMonthList.male" :key="index" class="mr-4 my-1">
                        <router-link class="category-item"
                          :to="{name: 'Lookbook', params: {gender: genders.male.id, year: month.year, month: month.month}}">Tháng {{ month.month }}
                        </router-link>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <search-form></search-form>
          </li>
        </ul>
        <ul class="navbar-nav align-items-center">
          <li class="nav-item bag">
            <a class="nav-link text-white d-flex align-items-center" @click="toggleIsOpenCartDialog">
              Giỏ hàng ({{ products.length }})
            </a>
            <cart-dialog v-if="isOpenCartDialog"></cart-dialog>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-dark text-uppercase" :to="{name: 'StoreFinder'}">
              Cửa hàng
            </router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" v-if="user" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ userName }}
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item">My Wishlist</a>
                <a class="dropdown-item" @click="logout">Đăng xuất</a>
              </div>
            </a>
            <a class="nav-link text-dark text-uppercase" @click="openLoginFormDialog" v-else>
              Đăng nhập
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <login-form-dialog :isOpenLoginFormDialog.sync="isOpenLoginFormDialog" @openRegisterFormDialog="openRegisterFormDialog"></login-form-dialog>
    <register-form-dialog :isOpenRegisterFormDialog.sync="isOpenRegisterFormDialog" @openLoginFormDialog="openLoginFormDialog"></register-form-dialog>
    <sidenav-overlay
      v-if="isOpenSidenavOverlay"
      :categories="categories"
      :lookbookMonthList="lookbookMonthList"
      :genders="genders"
      @close="isOpenSidenavOverlay = false"
      v-click-outside="{outsideCallback: closeSidenavOverlay}"
      @openLoginForm="isOpenLoginFormDialog = true"
      @goToCategoryPage="goToCategoryPage">
    </sidenav-overlay>
  </header>
</template>

<script>
import LoginFormDialog from '@/components/shared/LoginFormDialog';
import RegisterFormDialog from '@/components/shared/RegisterFormDialog';
import SidenavOverlay from './sidenav-overlay/SidenavOverlay';
import SearchForm from './search-form/SearchForm';
import CartDialog from '@/components/shared/cart-dialog/CartDialog';
import { mapState, mapMutations } from 'vuex';
import { reloadApp } from '@/shared/functions';
import { clickOutside } from '@/directives';
import userService from '@/shared/services/user.service';
import categoryService from '@/shared/services/category.service';
import lookbookService from '@/shared/services/lookbook.service';
import { GENDER } from '@/shared/constants';
import icon from '@/assets/images/icon.svg';

export default {
  components: {
    LoginFormDialog,
    RegisterFormDialog,
    SidenavOverlay,
    SearchForm,
    CartDialog
  },
  directives: {
    clickOutside
  },
  data() {
    return {
      isOpenSidenavOverlay: false,
      categories: [],
      isOpenLoginFormDialog: false,
      isOpenRegisterFormDialog: false,
      isLargeScreen: true,
      lookbookMonthList: {
        male: [],
        female: [],
        collapsed: true,
        maleCollapsed: true,
        femaleCollapsed: true
      },
      images: {
        icon
      }
    };
  },
  computed: {
    ...mapState(['user']),
    ...mapState('cart', [
      'products',
      'isOpenCartDialog'
    ]),
    genders() {
      return GENDER;
    },
    userName() {
      if (this.user.facebook_name) {
        return this.user.facebook_name;
      }
      if (this.user.google_name) {
        return this.user.google_name;
      }
      if (this.user.name) {
        return this.user.name;
      }
      return `${this.user.first_name} ${this.user.last_name}`;
    }
  },
  methods: {
    ...mapMutations('auth', [
      'removeToken'
    ]),
    ...mapMutations('cart', [
      'getCartFromStorage',
      'setIsOpenCartDialog'
    ]),
    goToCategoryPage() {
      this.$router.push({name: 'Category'});
    },
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
    closeSidenavOverlay() {
      this.isOpenSidenavOverlay = false;
    },
    toggleIsOpenCartDialog () {
      this.setIsOpenCartDialog(!this.isOpenCartDialog);
    },
    closeCart() {
      this.setIsOpenCartDialog(false);
    },
    onResize() {
      if (!window.matchMedia('(max-width: 992px)').matches) {
        this.isLargeScreen = true;
        if (this.isOpenSidenavOverlay) {
          this.closeSidenavOverlay();
        }
      } else {
        this.isLargeScreen = false;
      }
    },
    getCategories() {
      categoryService.getAll()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.categories = response.data;
          }
        });
    },
    getMaleMonthListSnapshot() {
      lookbookService.getMaleMonthListSnapshot()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.lookbookMonthList.male = response.data.data;
            this.lookbookMonthList.male.collapsed = true;
          }
        });
    },
    getFemaleMonthListSnapshot() {
      lookbookService.getFemaleMonthListSnapshot()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.lookbookMonthList.female = response.data.data;
            this.lookbookMonthList.female.collapsed = true;
          }
        });
    }
  },
  mounted() {
    if (window.matchMedia('(max-width: 992px)').matches) {
      this.isLargeScreen = false;
    } else {
      this.isLargeScreen = true;
    }

    this.getCategories();
    this.getCartFromStorage();
    this.getMaleMonthListSnapshot();
    this.getFemaleMonthListSnapshot();
    window.addEventListener('resize', this.onResize.bind(this));
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';
@import '~bootstrap/scss/bootstrap-grid';

.header {
  font-size: 0.7rem;
  background-color: #fefdfd;

  .category-list {
    // .dropdown-toggle {
    //   &:after {
    //     content: none;
    //   }
    // }
    .dropdown-item {
      background-color: transparent !important;

      &:active {
        outline: none;
        color: $black;
      }
    }
    .dropdown {
      position: unset;

      &:hover {
        .dropdown-menu {
          display: block;
        }
      }
    }
    .dropdown-menu {
      width: 100%;
      border: none;

      .sub-nav {
        .h6 {
          font-size: $font-size-base;
        }
        .category-item {
          font-size: $font-size-sm;
          color: inherit;
          border-bottom: 1px solid transparent;

          &:hover {
            transition: border-bottom .5s ease, border-bottom .5s ease;
            text-decoration: none;
            border-bottom-color: #000;
          }
        }
        .navbar-nav {
          max-height: 400px;
        }
      }
    }
  }

  .navbar-brand {
    margin-top: -7px;
    line-height: normal;
  }

  &>.navbar {
    height: 50px;
  }
  .bag {
    position: relative;

    &>a {
      height: 50px;
      background-color: rgba(45,45,45,.8);
    }
  }
  @include media-breakpoint-up(lg) {
    .category-list {
      height: 50px;
    }
  }
}
</style>
