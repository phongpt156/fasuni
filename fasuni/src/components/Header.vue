<template>
  <header class="header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand">Fasuni</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto align-items-center">
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
              <input class="form-control border-0 text-dark" type="search" placeholder="Enter keyword" aria-label="Search">
              <button class="btn my-2 my-sm-0 border-0 text-white" type="button">Search</button>
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
          <li class="nav-item">
            <a class="nav-link text-dark text-uppercase">
              My Wishlist
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark text-uppercase" @click="isOpenLoginFormDialog = true">
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
  methods: {
    openRegisterFormDialog() {
      this.isOpenLoginFormDialog = false;
      this.isOpenRegisterFormDialog = true;
    },
    openLoginFormDialog() {
      this.isOpenLoginFormDialog = true;
      this.isOpenRegisterFormDialog = false;
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

    &>.navbar {
      height: 50px;
    }

    .search-form {
      input {
        border-radius: 30px 0 0 30px;
        background-color: #dddddd;
      }
      button {
        border-radius: 0 30px 30px 0;
        background-color: #2d2d2d;
      }
    }

    .bag {
      height: 50px;
      background-color: $black;
    }
  }
</style>
