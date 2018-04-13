<template>
  <div class="collection">
    <img src="https://images.allsaints.com/static/1600/120418-THE-HAWAIIAN-PROJECT-HP.jpg" alt="" />
    <div class="my-4">
      <h6 class="text-uppercase mb-2 text-center">Have your say</h6>
      <p class="mb-0 text-center">In past seasons we have established the Hawaiian shirt as foundation of the Fasuni summer wardrobe.<br />To celebrate the iconic element of the brand, this season, we asked you to #HaveYourSay on what should be brought back from our archive.<br />The ten shirts, as chosen by you, will drop in April. Register your interest by clicking your favourite below</p>
      <hr class="my-5 mx-5" />
      <div class="row mx-4">
        <a class="px-2 product-item" v-for="product in products" :key="product.id">
          <img :src="product.image" alt="" class="img-fluid" />
          <p class="text-center mb-0 product-name">{{ product.name }}</p>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: [
        {
          id: 1,
          name: 'The Mokapu Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-01-V02.jpg'
        },
        {
          id: 2,
          name: 'The Helix Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-03.jpg'
        },
        {
          id: 3,
          name: 'The Offshore Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-02.jpg'
        },
        {
          id: 4,
          name: 'The Fuyugi Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-07.jpg'
        },
        {
          id: 5,
          name: 'The Wader Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-09.jpg'
        },
        {
          id: 6,
          name: 'The Yuka Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-04.jpg'
        },
        {
          id: 7,
          name: 'The Sumatra Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-12.jpg'
        },
        {
          id: 8,
          name: 'The Tsuru Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-06.jpg'
        },
        {
          id: 9,
          name: 'The Sumatra Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-05.jpg'
        },
        {
          id: 10,
          name: 'The Mauna Shirt',
          image: 'https://images.allsaints.com/static/600/220218-HAWAIIAN-SHIRTS-10.jpg'
        }
      ]
    };
  }
};
</script>

<style lang="scss">
  @import '~bootstrap/scss/functions';
  @import '~bootstrap/scss/_variables';

  .collection {
    background-color: $white;

    hr {
      border: 1px solid $black;
    }

    .product-item {
      width: calc(100% / 5);

      &:hover {
        img {
          opacity: 0.7
        }
        .product-name {
          visibility: visible;
        }
      }

      .product-name {
        font-size: $font-size-sm;
        visibility: hidden;
      }
    }
  }
</style>
