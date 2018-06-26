<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div :class="`modal-container modal-dialog modal-${size}`">
          <div class="modal-content" v-click-outside="{clickOutsideCallback: close}">
            <slot name="body"></slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    size: {
      type: String,
      default: 'lg'
    }
  },
  data() {
    return {

    };
  },
  directives: {
    clickOutside: {
      bind(el, binding, vnode) {
        const bindingValue = binding.value;

        function handler(e) {
          if (!el.contains(e.target)) {
            bindingValue.clickOutsideCallback();
          }
        }
        el.__vueClickOutside__ = {
          handler: handler
        };
        document.addEventListener('click', handler);
      },
      unbind(el) {
        document.removeEventListener('click', el.__vueClickOutside__.handler);
        delete el.__vueClickOutside__;
      }
    }
  },
  methods: {
    close() {
      this.$emit('close');
    }
  }
};
</script>

<style lang="scss">
  .modal {
    &-mask {
      z-index: 9998;
      width: 100%;
      top: 0;
      transition: opacity .3s ease;
      position: fixed;
      height: 100%;
      left: 0;
      display: table;
      background-color: rgba(0, 0, 0, .5);

      .body {
        margin: 20px 0;
      }
    }
    &-wrapper {
      vertical-align: middle;
      display: table-cell;
    }
    &-container {
      transition: all .3s ease;
      margin: 0px auto;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
      border-radius: 2px;
      background-color: #fff;
    }
    &-enter {
      opacity: 0;
    }
    &-leave-active {
      opacity: 0;
    }
    &-enter .modal-container, &-leave-active .modal-container {
      transform: scale(1.1);
    }
  }
</style>
