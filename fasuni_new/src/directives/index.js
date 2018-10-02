export const clickOutside = {
  bind(el, binding) {
    const bindingValue = binding.value;

    function handler (e) {
      if (bindingValue) {
        if (el.contains(e.target)) {
          if (bindingValue.insideCallback && Object.prototype.toString.call(bindingValue.insideCallback) === '[object Function]') {
            bindingValue.insideCallback();
          }
        } else {
          if (bindingValue.outsideCallback && Object.prototype.toString.call(bindingValue.outsideCallback) === '[object Function]') {
            bindingValue.outsideCallback();
          }
        }
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
};
