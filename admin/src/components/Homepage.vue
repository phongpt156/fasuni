<template>
  <div class="homepage">
    <layout :class="{'is-collapsed': isCollapsed}">
      <sider collapsible :collapsed-width="78" v-model="isCollapsed" :style="{zIndex: 9999, top: 0, position: 'fixed', minHeight: '100vh', left: 0}" breakpoint="md">
        <i-menu active-name="1-2" theme="dark" width="auto" :class="menuItemClasses">
          <menu-item name="1-1">
            <icon type="ios-navigate"></icon>
            <span>Option 1</span>
          </menu-item>
          <menu-item name="1-2">
            <icon type="search"></icon>
            <span>Option 2</span>
          </menu-item>
          <menu-item name="1-3">
            <icon type="settings"></icon>
            <span>Option 3</span>
          </menu-item>
        </i-menu>
      </sider>
      <layout>
        <i-header :style="{zIndex: '9998', width: '100%', position: 'fixed', background: '#fff', boxShadow: '0 2px 3px 2px rgba(0,0,0,.1)'}"></i-header>
        <i-content :style="{padding: '0 16px 16px'}">
          <breadcrumb :style="{margin: '16px 0'}">
            <breadcrumb-item>Home</breadcrumb-item>
            <breadcrumb-item>Components</breadcrumb-item>
            <breadcrumb-item>Layout</breadcrumb-item>
          </breadcrumb>
          <card>
            <div style="height: 600px">Content</div>
          </card>
        </i-content>
      </layout>
    </layout>
  </div>
</template>

<script>
export default {
  name: 'HelloWorld',
  data () {
    return {
      isCollapsed: false
    };
  },
  computed: {
    menuItemClasses() {
      return [
        'menu-item',
        this.isCollapsed ? 'collapsed-menu' : ''
      ];
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.homepage {
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
