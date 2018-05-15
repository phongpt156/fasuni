<template>
  <form class="form-inline search-form py-2">
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
      width: auto;
      min-width: 200px;
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
</style>
