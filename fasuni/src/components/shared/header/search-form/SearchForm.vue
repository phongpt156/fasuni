<template>
  <form class="form-inline search-form">
    <input class="form-control text-dark" type="search" placeholder="Enter keyword" aria-label="Search">
    <button class="btn my-2 my-sm-0 text-white" type="button">Search</button>
  </form>
</template>

<script>
export default {
  data() {
    return {

    };
  }
};
</script>

<style lang="scss">
  .search-form {
    input {
      border-radius: 30px 0 0 30px;
      border: 1px solid #dddee1;
      background-color: #dddddd;

      &:focus {
        box-shadow: unset;
      }
    }
    button {
      border-radius: 0 30px 30px 0;
      border: 1px solid #dddee1;
      background-color: #2d2d2d;
    }
  }
</style>
