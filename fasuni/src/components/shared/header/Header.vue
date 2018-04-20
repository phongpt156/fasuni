<template>
  <header class="header fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand h-100 d-flex align-items-center" @click="goToHomepage">Fasuni</a>
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
            <div class="dropdown-menu mt-0 p-4">
              <div class="dropdown-item">
                <ul class="navbar-nav sub-nav pr-3 d-inline-flex" v-for="category in category.children" :key="category.id">
                  <li>
                    <a class="h6 mb-3 d-block">{{ category.name }}</a>
                    <ul class="navbar-nav flex-column flex-wrap" v-if="category.children.length">
                      <li v-for="category in category.children" :key="category.id" class="mr-4 my-1">
                        <a class="category-item">{{ category.name }}</a>
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
          <li class="nav-item">
            <a class="nav-link text-white bag d-flex align-items-center">
              My Bag (5)
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark text-uppercase">
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
    <sidenav-overlay v-if="isOpenSidenavOverlay" :categories="categories"></sidenav-overlay>
  </header>
</template>

<script>
import LoginFormDialog from '@/components/shared/LoginFormDialog';
import RegisterFormDialog from '@/components/shared/RegisterFormDialog';
import Modal from '@/components/shared/Modal';
import SidenavOverlay from './sidenav-overlay/SidenavOverlay';
import SearchForm from './search-form/SearchForm';
import { mapState, mapMutations } from 'vuex';
import { reloadApp } from '@/shared/functions';
import userService from '@/shared/services/user.service';

export default {
  components: {
    LoginFormDialog,
    RegisterFormDialog,
    Modal,
    SidenavOverlay,
    SearchForm
  },
  data() {
    return {
      isOpenSidenavOverlay: false,
      categories: [
        {
          id: 1,
          name: `Women's`,
          children: [
            {
              id: 3,
              name: 'All Clothing',
              children: [
                {
                  id: 4,
                  name: 'Leather Jackets'
                },
                {
                  id: 5,
                  name: 'Coats & Jackets'
                },
                {
                  id: 6,
                  name: 'Knitwear'
                },
                {
                  id: 7,
                  name: 'Shirts'
                },
                {
                  id: 8,
                  name: 'Sweatshirts'
                },
                {
                  id: 9,
                  name: 'Hoodies'
                },
                {
                  id: 10,
                  name: 'Tailoring'
                },
                {
                  id: 11,
                  name: 'T-Shirts'
                },
                {
                  id: 12,
                  name: 'Polos'
                },
                {
                  id: 13,
                  name: 'Jeans'
                },
                {
                  id: 14,
                  name: 'Trousers'
                },
                {
                  id: 15,
                  name: 'Shorts'
                }
              ]
            }
          ],
          isOpenSubMenu: false
        },
        {
          id: 2,
          name: `Men's`,
          isOpenSubMenu: false
        }
      ],
      isOpenLoginFormDialog: false,
      isOpenRegisterFormDialog: false
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
    }
  },
  methods: {
    ...mapMutations('auth', [
      'removeToken'
    ]),
    goToHomepage() {
      this.$router.push({name: 'Homepage'});
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
    }
  }
};
</script>

<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';

  .header {
    font-size: $font-size-sm;
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

        .sub-nav {
          .h6 {
            font-size: $font-size-base;
          }
          .category-item {
            font-size: $font-size-sm;
            border-bottom: 1px solid transparent;

            &:hover {
              transition: border-bottom .5s ease, border-bottom .5s ease;
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
      font-size: 29px;
      font-family: SVN-Bear;
    }

    &>.navbar {
      height: 50px;
    }
    .bag {
      height: 50px;
      background-color: $black;
    }
  }
</style>
