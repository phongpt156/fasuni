<template>
  <i-menu :active-name="currentRouteName" theme="dark" width="auto" :class="menuItemClasses">
    <menu-item :name="route.name" v-for="route in routes" :key="route.meta && route.meta.parent ? route.meta.parent : route.name" @click.native="navigate(route)">
      <icon type="ios-navigate"></icon>
      <span>{{ route.name }}</span>
    </menu-item>
  </i-menu>
</template>

<script>
export default {
  props: {
    isCollapsed: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      routes: [
        {
          name: 'Homepage'
        },
        {
          name: 'Category'
        },
        {
          name: 'Product'
        },
        {
          name: 'Customer'
        },
        {
          name: 'Collection'
        },
        {
          name: 'Lookbook'
        }
      ]
    };
  },
  computed: {
    menuItemClasses() {
      return [
        'menu-item',
        this.isCollapsed ? 'collapsed-menu' : ''
      ];
    },
    currentRouteName() {
      if (this.$route.meta && this.$route.meta.parent) {
        return this.$route.meta.parent;
      }
      return this.$route.name;
    }
  },
  methods: {
    navigate(route) {
      this.$router.push(route);
    }
  }
};
</script>

<style lang="scss">
.menu-item {
  .router-link {
    color: #fff;
  }
}
</style>
