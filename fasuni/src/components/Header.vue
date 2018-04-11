<template>
  <header class="header fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand h-100 d-flex align-items-center">Fasuni</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto align-items-center category-list">
          <li
            class="nav-item dropdown"
            v-for="category in categories"
            :key="category.id">
            <a class="nav-link dropdown-toggle text-uppercase text-dark">
              {{ category.name }}
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-uppercase text-dark">
              Studio's
            </a>
          </li>
          <li class="nav-item">
            <form class="form-inline search-form">
              <input class="form-control text-dark" type="search" placeholder="Enter keyword" aria-label="Search">
              <button class="btn my-2 my-sm-0 text-white" type="button">Search</button>
            </form>
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
  </header>
</template>

<script>
import LoginFormDialog from '@/components/shared/LoginFormDialog';
import RegisterFormDialog from '@/components/shared/RegisterFormDialog';
import Modal from '@/components/shared/Modal';
import { mapState, mapMutations } from 'vuex';
import { reloadApp } from '@/shared/functions';
import userService from '@/shared/services/user.service';

export default {
  components: {
    LoginFormDialog,
    RegisterFormDialog,
    Modal
  },
  data() {
    return {
      categories: [
        { id: 1, name: `Women's`, parent_id: 0 },
        { id: 2, name: `Men's`, parent_id: 0 }
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

    .search-form {
      input {
        border-radius: 30px 0 0 30px;
        border: 1px solid #dddee1;
        background-color: #dddddd;

        &:focus {
          box-shadow: unset;
        }
      }
      button {
        border-radius: 0 30px 30px 0;
        border: 1px solid #dddee1;
        background-color: #2d2d2d;
      }
    }
    .bag {
      height: 50px;
      background-color: $black;
    }
  }
</style>
