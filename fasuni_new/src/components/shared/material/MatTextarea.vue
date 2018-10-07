<template>
  <div class="mat-input-container mb-4" :class="{'mat-input-focus': isFocus, 'has-error': hasError}">
    <div class="mb-1 mat-input-label">{{ inputLabel }}</div>
    <div class="mat-input-wrapper">
      <div class="mat-input-flex">
        <div class="mat-input-infix">
          <textarea
            class="mat-input-element"
            :type="type"
            :value="value"
            :placeholder="placeholder"
            @input="onInput($event.target.value)"
            @focus="isFocus = true"
            @blur="isFocus = false"
            v-autosize="value"
            rows="1">
          </textarea>
        </div>
      </div>
      <div class="mat-input-underline">
        <span class="mat-input-ripple"></span>
      </div>
      <div class="mat-input-error text-nowrap" v-if="hasError">{{ errorMessage }}</div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    placeholder: {
      type: String,
    },
    required: {
      type: Boolean,
      default: false,
    },
    type: {
      type: String,
      default: 'text',
    },
    value: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    prop: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      isFocus: false,
      isValidateWhenTyping: false,
      errorMessage: '',
      hasError: false,
      validator: '',
      errorMessages: {
        required: '',
        validator: '',
      },
    };
  },
  computed: {
    inputLabel() {
      return this.required ? `${this.label}*` : this.label;
    },
  },
  methods: {
    onInput(value) {
      this.$emit('input', value);
      if (this.isValidateWhenTyping) {
        this.validate(value);
      }
    },
    validate(value) {
      this.hasError = false;

      if (this.required) {
        if (value === '') {
          this.hasError = true;
          this.errorMessage = this.errorMessages.required;
          return;
        }
      }
      if (this.validator) {
        if (!this.validator.test(value)) {
          this.hasError = true;
          this.errorMessage = this.errorMessages.validator;
        }
      }
    },
  },
};
</script>

<style lang="scss">
$accent-color: rgb(0, 113, 56);
$danger-color: #f44336;

.mat-input {
  &-container {
    width: 100%;

    &.has-error {
      .mat-input {
        &-label {
          color: $danger-color;
        }
        &-element {
          caret-color: $danger-color;

          &::-webkit-input-placeholder {
            color: $danger-color;
          }
        }
        &-underline {
          background-color: $danger-color;

          .mat-input-ripple {
            background-color: $danger-color;
          }
        }
      }
    }
  }
  &-wrapper {
    position: relative;
  }
  &-flex {
    width: 100%;
    display: inline-flex;
    align-items: baseline;
  }
  &-infix {
    width: 180px;
    position: relative;
    min-width: 0;
    flex: auto;
    display: block;

    .mat-input-element {
      width: 100%;
      vertical-align: bottom;
      resize: none;
      padding: 0;
      outline: 0;
      max-width: 100%;
      caret-color: $accent-color;
      border: none;
      background-color: transparent;
    }
  }
  &-underline {
    width: 100%;
    position: absolute;
    height: 1px;
    bottom: 0;
    background-color: rgba(0,0,0,.42);

    .mat-input-ripple {
      width: 100%;
      visibility: hidden;
      transition: background-color .3s cubic-bezier(.55,0,.55,.2);
      transform-origin: 50%;
      transform: scaleX(.5);
      opacity: 0;
      top: 0;
      position: absolute;
      left: 0;
      height: 2px;
      background-color: $accent-color;
    }
  }
  &-focus {
    .mat-input {
      &-ripple {
        visibility: visible;
        transition: transform .3s cubic-bezier(.25,.8,.25,1),opacity .1s cubic-bezier(.25,.8,.25,1), background-color .3s cubic-bezier(.25,.8,.25,1);
        transform: scaleX(1);
        opacity: 1;
      }
    }
  }
  &-error {
    position: absolute;
    font-size: 75%;
    color: $danger-color;
    bottom: -17px;
  }
}
</style>
