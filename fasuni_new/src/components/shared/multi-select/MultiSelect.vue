<template>
  <div class="multi-select" v-click-outside="{outsideCallback: closeOptionList}">
    <div class="placeholder d-flex justify-content-between align-items-center" @click="isOpenOptionList = !isOpenOptionList">{{ placeholder }}</div>

    <ul class="option-list p-0 m-0 w-100 bg-white" v-if="isOpenOptionList">
      <li v-for="option in options" :key="option[distinct]" class="option-item px-3 py-1" @click="selectOption(option[trackBy])" :class="{active: isActive(option[trackBy])}">{{ option[label] }}</li>
    </ul>
  </div>
</template>

<script>
import { clickOutside } from '@/directives';

export default {
  props: {
    options: {
      type: Array,
      default() {
        return [];
      },
    },
    placeholder: {
      type: String,
      default: 'Chọn',
    },
    label: {
      type: String,
    },
    value: {
      type: [String, Array],
    },
    content: {
      type: String,
    },
    distinct: {
      type: String,
    },
    trackBy: {
      type: String,
    },
  },
  directives: {
    clickOutside,
  },
  computed: {
    isActive() {
      return item => {
        const exist = this.value.find(option => {
          return option === item;
        });

        if (exist) {
          return true;
        }
        return false;
      };
    },
  },
  data() {
    return {
      isOpenOptionList: false,
    };
  },
  methods: {
    closeOptionList() {
      this.isOpenOptionList = false;
    },
    selectOption(option) {
      this.$emit('click', option);
    },
  },
};
</script>

<style lang="scss">
.multi-select {
  position: relative;

  .placeholder {
    width: 173px;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    padding: 0.375rem 0.75rem;
    font-weight: 400;
    font-size: 0.875rem;
    cursor: pointer;
    color: #343a40;
    border-radius: 0.25rem;
    border: 1px solid #6c757d;
    background-color: #dddddd;

    &::after {
      width: 0;
      vertical-align: 0.255em;
      margin-left: 0.255em;
      height: 0;
      display: inline-block;
      content: "";
      border-top: 0.3em solid;
      border-right: 0.3em solid transparent;
      border-left: 0.3em solid transparent;
      border-bottom: 0;
    }
    &:active {
      color: #fff;
      border-color: #4e555b;
      background-color: #545b62;
    }
  }
  .option-list {
    z-index: 1000;
    top: 40px;
    position: absolute;
    overflow: auto;
    max-height: 50vh;
    list-style: none;
    left: 0;
    cursor: pointer;
    border-radius: 0.25rem;
    border: 1px solid rgba(0, 0, 0, 0.15);

    .option-item {
      color: #16181b;

      &.active {
        color: #fff;
        background-color: #545b62;
      }
      &:hover {
        color: #fff;
        background-color: #545b62;
      }
    }
  }
}
</style>
