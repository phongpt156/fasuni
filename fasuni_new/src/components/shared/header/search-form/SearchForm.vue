<template>
  <form class="form-inline search-form flex-nowrap" @submit.prevent="onSubmit">
    <input class="form-control text-dark" type="search" placeholder="Enter keyword" aria-label="Search" v-model="name">
    <button class="btn text-white" type="submit">Search</button>
  </form>
</template>

<script>

export default {
  data() {
    return {
      name: ''
    };
  },
  methods: {
    onSubmit() {
      if (this.name) {
        this.$router.push({name: 'Search', params: {name: this.name}});
      }
    }
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/bootstrap-grid';

.search-form {
  input {
    width: auto;
    height: auto;
    font-size: 0.7rem;
    display: inline-block;
    border-radius: 30px 0 0 30px;
    border: 1px solid #dddee1;
    background-color: #dddddd;

    &:focus {
      box-shadow: unset;
      border-color: #ced4da;
    }
  }
  button {
    width: auto;
    font-size: 0.7rem;
    display: inline-block;
    border-radius: 0 30px 30px 0;
    border: 1px solid #dddee1;
    background-color: rgba(45, 45, 45, .8);
  }
}

@include media-breakpoint-up(lg) {
  .search-form {

    input {
      min-width: 200px;
    }
  }
}
@include media-breakpoint-down(md) {
  .search-form {
    padding-top: 1rem;

    input {
      min-width: 200px;
      flex-grow: 1;
    }
  }
}
</style>
