<template>
  <div class="main-layout">
    <layout :class="{'is-collapsed': isCollapsed}">
      <sider collapsible :collapsed-width="78" v-model="isCollapsed" :style="{zIndex: 9999, top: 0, position: 'fixed', minHeight: '100vh', left: 0}" breakpoint="md">
        <aside-nav :isCollapsed="isCollapsed"></aside-nav>
      </sider>
      <layout>
        <i-header :style="{zIndex: '9998', width: '100%', position: 'fixed', background: '#fff', boxShadow: '0 2px 3px 2px rgba(0,0,0,.1)'}">
          <row type="flex" justify="end">
            <i-col pull="1">
              <dropdown trigger="click">
                <a v-if="user">
                  {{ user.name }}
                  <Icon type="arrow-down-b"></Icon>
                </a>
                <dropdown-menu slot="list">
                  <dropdown-item @click.native="logout">Đăng xuất</dropdown-item>
                </dropdown-menu>
              </dropdown>
            </i-col>
          </row>
        </i-header>
        <i-content :style="{padding: '0 16px 16px'}">
          <breadcrumb :style="{margin: '16px 0'}">
            <breadcrumb-item>{{ $route.meta.title }}</breadcrumb-item>
          </breadcrumb>
          <card>
            <slot></slot>
          </card>
        </i-content>
      </layout>
    </layout>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex';
import AsideNav from '@/components/common/AsideNav';

export default {
  components: {
    AsideNav
  },
  data () {
    return {
      isCollapsed: false
    };
  },
  computed: {
    ...mapState('user', [
      'user'
    ]),
    menuItemClasses() {
      return [
        'menu-item',
        this.isCollapsed ? 'collapsed-menu' : ''
      ];
    }
  },
  methods: {
    ...mapMutations('user', [
      'setUser'
    ]),
    ...mapMutations('auth', [
      'removeToken'
    ]),
    logout() {
      this.removeToken();
      this.setUser(null);
      this.$router.push({name: 'Login'});
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.main-layout {
  .ml-78 {
    margin-left: 78px !important;
  }
  .menu-item {
    span {
      display: inline-block;
      overflow: hidden;
      width: 69px;
      text-overflow: ellipsis;
      white-space: nowrap;
      vertical-align: bottom;
      transition: width .2s ease .2s;
    }
    i {
      transform: translateX(0px);
      transition: font-size .2s ease, transform .2s ease;
      vertical-align: middle;
      font-size: 16px;
    }
  }
  .collapsed-menu {
    span {
      width: 0px;
      transition: width .2s ease;
    }
    i {
      transform: translateX(5px);
      transition: font-size .2s ease .2s, transform .2s ease .2s;
      vertical-align: middle;
      font-size: 22px;
    }
  }
  .ivu-layout {
    &-has-sider {
      transition: all .2s ease-in-out;
      margin-top: 64px;
      margin-left: 200px;

      &.is-collapsed {
        margin-left: 78px;

        .ivu-layout-header {
          padding: 0 0 0 78px;
        }
      }
    }
    &-header {
      top: 0;
      padding: 0 0 0 200px;
      left: 0;
    }
  }
}
</style>
