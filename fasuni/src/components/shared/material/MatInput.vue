<template>
  <div class="mat-input-container" :class="{'mat-input-focus': isFocus}">
    <div class="mat-input-wrapper">
      <div class="mat-input-flex">
        <div class="mat-input-infix">
          <input
            class="mat-input-element"
            :type="type"
            :value="value"
            @input="$emit('input', $event.target.value)"
            @focus="isFocus = true"
            @blur="isFocus = false"
            @change="test" />
          <span class="mat-input-placeholder-wrapper">
            <label class="mat-input-placeholder" :class="{'mat-input-not-empty': value.length}">
              {{ placeholder }}
              <span class="mat-input-required-marker" v-if="required">*</span>
            </label>
          </span>
        </div>
      </div>
      <div class="mat-input-underline">
        <span class="mat-input-ripple"></span>
      </div>
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
      type: String
    }
  },
  data() {
    return {
      isFocus: false
    };
  },
  methods: {
    test() {

    }
  }
};
</script>

<style lang="scss">
  $accent-color: #3f51b5;

  .mat-input {
    &-container {
      width: 100%;
    }
    &-wrapper {
      position: relative;
      padding-bottom: 1.25em;
    }
    &-flex {
      width: 100%;
      display: inline-flex;
      align-items: baseline;
    }
    &-infix {
      width: 180px;
      position: relative;
      padding: .4375em 0;
      min-width: 0;
      flex: auto;
      display: block;
      border-top: .84375em solid transparent;

      .mat-input-element {
        width: 100%;
        vertical-align: bottom;
        padding: 0;
        outline: 0;
        max-width: 100%;
        margin-top: -.0625em;
        caret-color: $accent-color;
        border: none;
      }
    }
    &-placeholder-wrapper {
      width: 100%;
      top: -.84375em;
      position: absolute;
      pointer-events: none;
      padding-top: .84375em;
      overflow: hidden;
      left: 0;
      height: 100%;
      box-sizing: content-box;
    }
    &-placeholder {
      width: 100%;
      white-space: nowrap;
      transition: transform .4s cubic-bezier(.25,.8,.25,1),color .4s cubic-bezier(.25,.8,.25,1),width .4s cubic-bezier(.25,.8,.25,1);
      transform-origin: 0 0;
      transform: perspective(100px);
      top: 1.28125em;
      text-overflow: ellipsis;
      position: absolute;
      pointer-events: none;
      overflow: hidden;
      left: 0;
      color: rgba(0,0,0,.54);
    }
    &-underline {
      width: 100%;
      position: absolute;
      height: 1px;
      bottom: 1.25em;
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
        &-placeholder {
          transform: translateY(-1.28125em) scale(.75) perspective(100px) translateZ(.001px);
        }
        &-ripple {
          visibility: visible;
          transition: transform .3s cubic-bezier(.25,.8,.25,1),opacity .1s cubic-bezier(.25,.8,.25,1),background-color .3s cubic-bezier(.25,.8,.25,1);
          transform: scaleX(1);
          opacity: 1;
        }
      }
    }
    &-not-empty {
      transform: translateY(-1.28125em) scale(.75) perspective(100px) translateZ(.001px);
    }
  }
</style>
