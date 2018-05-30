<template>
  <div class="lookbook-list">
    <div class="row mx-0">
      <div
        v-for="lookbook in lookbooks"
        :key="lookbook.id"
        class="col-md-3 col-sm-6 p-2">
        <lookbook-item :lookbook="lookbook">
        </lookbook-item>
      </div>
    </div>
  </div>
</template>

<script>
import LookbookItem from './lookbook-item/LookbookItem';

export default {
  components: {
    LookbookItem
  },
  data() {
    return {
      lookbooks: [
        {
          id: 1,
          name: 'Look 1',
          image: 'https://images.allsaints.com/static/600/HP-MARCH-2018-MW-01.jpg',
          products: [
            {
              id: 1,
              name: 'Áo tà lụa',
              price: '1200000'
            },
            {
              id: 2,
              name: 'Quần kaki',
              price: '900000'
            },
            {
              id: 3,
              name: 'Túi xách',
              price: '450000'
            }
          ]
        },
        {
          id: 2,
          name: 'Look 2',
          image: 'https://images.allsaints.com/static/600/HP-MARCH-2018-MW-02.jpg',
          products: [
            {
              id: 1,
              name: 'Áo tà lụa',
              price: '1200000'
            },
            {
              id: 2,
              name: 'Quần kaki',
              price: '900000'
            },
            {
              id: 3,
              name: 'Túi xách',
              price: '450000'
            }
          ]
        },
        {
          id: 3,
          name: 'Look 3',
          image: 'https://images.allsaints.com/static/600/HP-MARCH-2018-MW-03.jpg',
          products: [
            {
              id: 1,
              name: 'Áo tà lụa',
              price: '1200000'
            },
            {
              id: 2,
              name: 'Quần kaki',
              price: '900000'
            },
            {
              id: 3,
              name: 'Túi xách',
              price: '450000'
            }
          ]
        },
        {
          id: 4,
          name: 'Look 4',
          image: 'https://images.allsaints.com/static/600/HP-MARCH-2018-MW-04.jpg',
          products: [
            {
              id: 1,
              name: 'Áo tà lụa',
              price: '1200000'
            },
            {
              id: 2,
              name: 'Quần kaki',
              price: '900000'
            },
            {
              id: 3,
              name: 'Túi xách',
              price: '450000'
            }
          ]
        },
        {
          id: 5,
          name: 'Look 5',
          image: 'https://images.allsaints.com/static/600/HP-MARCH-2018-MW-05.jpg',
          products: [
            {
              id: 1,
              name: 'Áo tà lụa',
              price: '1200000'
            },
            {
              id: 2,
              name: 'Quần kaki',
              price: '900000'
            },
            {
              id: 3,
              name: 'Túi xách'
            }
          ]
        },
        {
          id: 6,
          name: 'Look 6',
          image: 'https://images.allsaints.com/static/600/HP-MARCH-2018-MW-06.jpg',
          products: [
            {
              id: 1,
              name: 'Áo tà lụa',
              price: '1200000'
            },
            {
              id: 2,
              name: 'Quần kaki',
              price: '900000'
            },
            {
              id: 3,
              name: 'Túi xách',
              price: '450000'
            }
          ]
        }
      ]
    };
  }
};
</script>

<style>

</style>
