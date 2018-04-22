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
            <div>
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
                    <div>
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
                          <div v-for="children1 in children.children" :key="children1.id">
                            <a
                              class="p-3 pl-5 d-flex justify-content-between category-link"
                              :class="{'custom-background': children1.children && children1.children.length && !children1.collapsed}"
                              @click="$emit('goToCategoryPage')">
                              {{ children1.name }}
                            </a>
                          </div>
                        </template>
                      </div>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
          <!-- <div class="category-item">
            <a>Studio's</a>
          </div> -->
        </div>

        <search-form class="my-2 px-3"></search-form>
        <a class="p-3 d-flex justify-content-between category-link">
          Store Finder
        </a>
        <div>
          <a v-if="user" id="userDropdownMobile" data-toggle="dropdown" class="p-3 d-flex justify-content-between category-link">
            {{ userName }}
            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="userDropdownMobile">
              <a class="dropdown-item">My Wishlist</a>
              <a class="dropdown-item" @click="logout">Đăng xuất</a>
            </div>
          </a>
          <a class="d-flex p-3" @click="$emit('openLoginForm')" v-else>
            Sign in
          </a>
        </div>
      </div>
    </vue-perfect-scrollbar>
  </div>
</template>

<script>
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import VuePerfectScrollbar from 'vue-perfect-scrollbar';
import timesIcon from '@fortawesome/fontawesome-free-solid/faTimes';
import plusIcon from '@fortawesome/fontawesome-free-solid/faPlus';
import minusIcon from '@fortawesome/fontawesome-free-solid/faMinus';
import SearchForm from './../search-form/SearchForm';
// import Modal from '@/components/shared/Modal';
import { mapState, mapMutations } from 'vuex';
import { reloadApp } from '@/shared/functions';
import userService from '@/shared/services/user.service';

export default {
  props: {
    categories: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  components: {
    SearchForm,
    FontAwesomeIcon,
    VuePerfectScrollbar
  },
  data() {
    return {
      icons: {
        times: timesIcon,
        plus: plusIcon,
        minus: minusIcon
      }
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
  },
  mounted() {
    this.setToggleableCategories(this.categories);
  }
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
      &:hover {
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
