<template>
  <form class="mat-form" ref="form" @submit.prevent="onSubmit">
    <slot></slot>
  </form>
</template>

<script>
export default {
  props: {
    model: {
      type: Object,
      default() {
        return {};
      }
    },
    rules: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  data() {
    return {
    };
  },
  methods: {
    onSubmit() {
      this.validate();
    },
    validate() {
      let focused = false;

      this.$children.forEach((childComponent, index) => {
        childComponent.isValidateWhenTyping = true;
        childComponent.validate(childComponent.value);
        if (childComponent.hasError && !focused) {
          focused = true;
          this.$refs.form[index].focus();
        }
      });
    }
  },
  mounted() {
    if (this.$refs.form[0]) {
      this.$refs.form[0].focus();
    };

    for (const key of Object.keys(this.model)) {
      this.$children.forEach(childComponent => {
        if (childComponent.prop === key) {
          if (this.rules[key]) {
            this.rules[key].forEach(rule => {
              if (rule.required) {
                childComponent.errorMessages.required = rule.message;
              } else if (rule.validator) {
                childComponent.validator = rule.validator;
                childComponent.errorMessages.validator = rule.message;
              }
            });
          }
        }
      });
    }
  }
};
</script>
