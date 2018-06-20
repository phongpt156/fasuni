<template>
  <form class="mat-form" ref="form" @submit.prevent="onSubmit" :class="{inline: inline}">
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
    },
    inline: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      isValid: true,
      fields: {}
    };
  },
  methods: {
    onSubmit() {
      this.$emit('submit');
    },
    validate() {
      let focused = false;
      let isValid = true;

      this.$children.forEach((childComponent, index) => {
        childComponent.isValidateWhenTyping = true;

        if (childComponent.validate) {
          childComponent.validate(childComponent.value);

          if (childComponent.hasError && !focused) {
            isValid = false;
            focused = true;
            this.$refs.form[index].focus();
          }
        }
      });
      this.isValid = isValid;
    },
    addError(field, message) {
      this.fields[field].hasError = true;
      this.fields[field].errorMessage = message;
      const input = this.fields[field].$el.querySelector('input');
      if (input) {
        input.focus();
      }
    }
  },
  mounted() {
    if (this.$refs.form[0]) {
      this.$refs.form[0].focus();
    };

    for (const key of Object.keys(this.model)) {
      this.$children.forEach(childComponent => {
        if (childComponent.prop === key) {
          this.fields[key] = childComponent;

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

<style lang="scss">
.mat-form {
  &.inline {
    .mat-input, .mat-select {
      &-container {
        display: flex;
      }
      &-label {
        width: 150px;
        margin-right: 20px;
      }
      &-wrapper {
        top: -5px;
        flex-grow: 1;
      }
    }
  }
}
</style>
