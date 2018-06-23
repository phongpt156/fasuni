<template>
  <div class="mat-select-container mb-4" :class="{'mat-select-focus': isFocus, 'mat-select-default': value === '', 'has-error': hasError}">
    <div class="mb-1 mat-select-label">{{ inputLabel }}</div>
    <div class="mat-select-wrapper">
      <div class="mat-select-flex">
        <div class="mat-select-infix">
          <select
            class="mat-select-element"
            @change="onChange($event.target.value)"
            :value="value"
            @focus="isFocus = true"
            @blur="isFocus = false">
            <option value="" style="color: rgb(117, 117, 117)">{{ placeholder }}</option>
            <slot name="option"></slot>
          </select>
        </div>
      </div>
      <div class="mat-select-underline">
        <span class="mat-select-ripple"></span>
      </div>
      <div class="mat-select-error text-nowrap" v-if="hasError">{{ errorMessage }}</div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    placeholder: {
      type: String
    },
    required: {
      type: Boolean,
      default: false
    },
    type: {
      type: String,
      default: 'text'
    },
    value: {
      type: [Number, String, Object],
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    prop: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      isFocus: false,
      errorMessage: '',
      hasError: false,
      errorMessages: {
        required: '',
        validator: ''
      }
    };
  },
  computed: {
    inputLabel() {
      return this.required ? `${this.label}*` : this.label;
    }
  },
  methods: {
    onChange(value) {
      this.hasError = false;
      this.$emit('input', value);
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
    }
  }
};
</script>

<style lang="scss">
$accent-color: rgb(0, 113, 56);
$danger-color: #f44336;

.mat-select {
  &-container {
    width: 100%;

    &.has-error {
      .mat-select {
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

          .mat-select-ripple {
            background-color: $danger-color;
          }
        }
      }
    }
  }
  &-default {
    .mat-select-element {
      color: rgb(117, 117, 117);
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

    .mat-select-element {
      width: 100%;
      vertical-align: bottom;
      padding: 0;
      outline: 0;
      max-width: 100%;
      cursor: pointer;
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

    .mat-select-ripple {
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
    .mat-select {
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
