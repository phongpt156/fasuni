<template>
  <header class="header fixed-top shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand branding-name h-100 d-flex align-items-center" @click="goToHomepage">Fasuni</a>
      <button class="navbar-toggler" type="button" @click="isOpenSidenavOverlay = !isOpenSidenavOverlay">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto align-items-center category-list">
          <li
            class="nav-item dropdown"
            v-for="category in categories"
            :key="category.id">
            <a class="nav-link dropdown-toggle text-uppercase text-dark" data-toggle="dropdown">
              {{ category.name }}
            </a>
            <div class="dropdown-menu mt-0 p-4 shadow-sm">
              <div class="dropdown-item px-5">
                <ul class="navbar-nav sub-nav pr-5 d-inline-flex" v-for="category in category.children" :key="category.id">
                  <li>
                    <a class="h6 mb-3 d-block font-weight-bold">{{ category.name }}</a>
                    <ul class="navbar-nav flex-column flex-wrap" v-if="category.children.length">
                      <li v-for="category in category.children" :key="category.id" class="mr-4 my-1">
                        <router-link class="category-item"
                          @click="goToCategoryPage"
                          :to="{name: 'Category', params: {slug: category.slug}}">{{ category.name }}
                        </router-link>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-uppercase text-dark">
              Studio's
            </a>
          </li>
          <li class="nav-item">
            <search-form></search-form>
          </li>
        </ul>
        <ul class="navbar-nav align-items-center">
          <li class="nav-item bag">
            <a class="nav-link text-white d-flex align-items-center" @click="toggleIsOpenCartDialog">
              My Bag ({{ products.length }})
            </a>
            <cart-dialog v-if="isOpenCartDialog"></cart-dialog>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark text-uppercase" @click="$router.push({name: 'StoreFinder'})">
              Store Finder
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" v-if="user" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ userName }}
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item">My Wishlist</a>
                <a class="dropdown-item" @click="logout">Đăng xuất</a>
              </div>
            </a>
            <a class="nav-link text-dark text-uppercase" @click="isOpenLoginFormDialog = true" v-else>
              Sign in
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
import Modal from '@/components/shared/Modal';
import SidenavOverlay from './sidenav-overlay/SidenavOverlay';
import SearchForm from './search-form/SearchForm';
import CartDialog from '@/components/shared/cart-dialog/CartDialog';
import { mapState, mapMutations } from 'vuex';
import { reloadApp } from '@/shared/functions';
import userService from '@/shared/services/user.service';
import { clickOutside } from '@/directives';
import categoryService from '@/shared/services/category.service';

export default {
  components: {
    LoginFormDialog,
    RegisterFormDialog,
    Modal,
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
      categories: [
        // {
        //   id: 1,
        //   name: `Women's`,
        //   children: [
        //     {
        //       id: 3,
        //       name: 'Handbags',
        //       children: [
        //         {
        //           id: 4,
        //           name: 'Top Handles & Boston Bags'
        //         },
        //         {
        //           id: 5,
        //           name: 'Totes'
        //         },
        //         {
        //           id: 6,
        //           name: 'Shoulder Bags'
        //         },
        //         {
        //           id: 7,
        //           name: 'Belt Bags'
        //         },
        //         {
        //           id: 8,
        //           name: 'Backpacks'
        //         },
        //         {
        //           id: 9,
        //           name: 'Mini Bags'
        //         },
        //         {
        //           id: 10,
        //           name: 'Clutches & Evening'
        //         },
        //         {
        //           id: 11,
        //           name: 'Precious Skins'
        //         }
        //       ]
        //     },
        //     {
        //       id: 12,
        //       name: 'Ready-To-Wear',
        //       children: [
        //         {
        //           id: 13,
        //           name: 'Dresses'
        //         },
        //         {
        //           id: 14,
        //           name: 'Leather & Casual Jackets'
        //         },
        //         {
        //           id: 15,
        //           name: 'Coats & Furs'
        //         },
        //         {
        //           id: 16,
        //           name: 'Outerwear'
        //         },
        //         {
        //           id: 17,
        //           name: 'Tops & Shirts'
        //         },
        //         {
        //           id: 18,
        //           name: 'Sweaters & Cardigans'
        //         },
        //         {
        //           id: 19,
        //           name: 'Sweatshirts & T-Shirts'
        //         },
        //         {
        //           id: 20,
        //           name: 'Skirts'
        //         },
        //         {
        //           id: 21,
        //           name: 'Pants & Shorts'
        //         },
        //         {
        //           id: 22,
        //           name: 'Denim'
        //         }
        //       ]
        //     },
        //     {
        //       id: 23,
        //       name: 'Shoes',
        //       children: [
        //         {
        //           id: 24,
        //           name: 'Pumps'
        //         },
        //         {
        //           id: 25,
        //           name: 'Sandals'
        //         },
        //         {
        //           id: 26,
        //           name: 'Moccasins & Loafers'
        //         },
        //         {
        //           id: 27,
        //           name: 'Ballerinas'
        //         },
        //         {
        //           id: 28,
        //           name: 'Slides & Mules'
        //         },
        //         {
        //           id: 29,
        //           name: 'Boots & Booties'
        //         },
        //         {
        //           id: 30,
        //           name: 'Espadrilles & Wedges'
        //         },
        //         {
        //           id: 31,
        //           name: 'Sneakers'
        //         }
        //       ]
        //     },
        //     {
        //       id: 32,
        //       name: 'Accessories',
        //       children: [
        //         {
        //           id: 33,
        //           name: 'Luggage & Lifestyle Bags'
        //         },
        //         {
        //           id: 34,
        //           name: 'Luggage & Lifestyle Bags'
        //         },
        //         {
        //           id: 35,
        //           name: 'Belts'
        //         },
        //         {
        //           id: 36,
        //           name: 'Belts'
        //         },
        //         {
        //           id: 37,
        //           name: 'Silks & Scarves'
        //         },
        //         {
        //           id: 38,
        //           name: 'Jewellery'
        //         },
        //         {
        //           id: 39,
        //           name: 'Jewellery'
        //         },
        //         {
        //           id: 40,
        //           name: 'Sunglasses'
        //         },
        //         {
        //           id: 41,
        //           name: 'Fans'
        //         },
        //         {
        //           id: 42,
        //           name: 'Fans'
        //         }
        //       ]
        //     }
        //   ],
        //   isOpenSubMenu: false
        // },
        // {
        //   id: 2,
        //   name: `Men's`,
        //   isOpenSubMenu: false
        // }
      ],
      isOpenLoginFormDialog: false,
      isOpenRegisterFormDialog: false
    };
  },
  computed: {
    ...mapState(['user']),
    ...mapState('cart', [
      'products',
      'isOpenCartDialog'
    ]),
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
    goToHomepage() {
      this.$router.push({name: 'Homepage'});
    },
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
      if (!window.matchMedia('(max-width: 992px)').matches && this.isOpenSidenavOverlay) {
        this.closeSidenavOverlay();
      }
    },
    getCategories() {
      categoryService.getAll()
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.categories = response.data;
          }
        });
    }
  },
  mounted() {
    this.getCategories();
    this.getCartFromStorage();
    window.addEventListener('resize', this.onResize.bind(this));
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';

.header {
  font-size: 0.7rem;
  background-color: #fefdfd;

  .category-list {
    .dropdown-toggle {
      &:after {
        content: none;
      }
    }
    .dropdown-item {
      background-color: transparent !important;

      &:active {
        outline: none;
        color: $black;
      }
    }
    .dropdown-menu {
      width: 100%;
      top: 50px;
      position: fixed;
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
}
</style>
