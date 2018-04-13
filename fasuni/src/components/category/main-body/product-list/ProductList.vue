<template>
  <div class="product-list">
    <div class="row mx-0">
      <div v-for="product in products" :key="product.id" class="col-md-3 col-sm-6 px-0">
        <product-card :product="product"></product-card>
      </div>
    </div>
  </div>
</template>

<script>
import ProductCard from './product-card/ProductCard';

export default {
  name: 'ProductList',
  components: {
    ProductCard
  },
  data() {
    return {
      products: [
        {
          id: 1,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/ML003N/5/ML003N-5-1.jpg',
          colors: [
            {
              id: 1,
              code: '#000'
            },
            {
              id: 2,
              code: '#7cc576'
            },
            {
              id: 3,
              code: '#fbced5'
            },
            {
              id: 4,
              code: '#ff00ff'
            },
            {
              id: 5,
              code: '#fff'
            }
          ],
          sizes: [
            {
              id: 1,
              name: 'XS',
              quantity: 0
            },
            {
              id: 2,
              name: 'S',
              quantity: 1
            },
            {
              id: 3,
              name: 'M',
              quantity: 1
            },
            {
              id: 4,
              name: 'L',
              quantity: 1
            },
            {
              id: 5,
              name: 'XL',
              quantity: 1
            },
            {
              id: 6,
              name: 'XXL',
              quantity: 1
            }
          ]
        },
        {
          id: 2,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/ML003N/5/ML003N-5-1.jpg',
          colors: [
            {
              id: 1,
              code: '#000'
            },
            {
              id: 2,
              code: '#7cc576'
            },
            {
              id: 3,
              code: '#fbced5'
            },
            {
              id: 4,
              code: '#ff00ff'
            },
            {
              id: 5,
              code: '#fff'
            }
          ],
          sizes: [
            {
              id: 1,
              name: 'XS'
            },
            {
              id: 2,
              name: 'S'
            },
            {
              id: 3,
              name: 'M'
            },
            {
              id: 4,
              name: 'L'
            },
            {
              id: 5,
              name: 'XL'
            },
            {
              id: 6,
              name: 'XXL'
            }
          ]
        },
        {
          id: 3,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/ML003N/5/ML003N-5-1.jpg',
          colors: [
            {
              id: 1,
              code: '#000'
            },
            {
              id: 2,
              code: '#7cc576'
            },
            {
              id: 3,
              code: '#fbced5'
            },
            {
              id: 4,
              code: '#ff00ff'
            },
            {
              id: 5,
              code: '#fff'
            }
          ],
          sizes: [
            {
              id: 1,
              name: 'XS'
            },
            {
              id: 2,
              name: 'S'
            },
            {
              id: 3,
              name: 'M'
            },
            {
              id: 4,
              name: 'L'
            },
            {
              id: 5,
              name: 'XL'
            },
            {
              id: 6,
              name: 'XXL'
            }
          ]
        },
        {
          id: 4,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/ML003N/5/ML003N-5-1.jpg',
          colors: [
            {
              id: 1,
              code: '#000'
            },
            {
              id: 2,
              code: '#7cc576'
            },
            {
              id: 3,
              code: '#fbced5'
            },
            {
              id: 4,
              code: '#ff00ff'
            },
            {
              id: 5,
              code: '#fff'
            }
          ],
          sizes: [
            {
              id: 1,
              name: 'XS'
            },
            {
              id: 2,
              name: 'S'
            },
            {
              id: 3,
              name: 'M'
            },
            {
              id: 4,
              name: 'L'
            },
            {
              id: 5,
              name: 'XL'
            },
            {
              id: 6,
              name: 'XXL'
            }
          ]
        }
      ]
    };
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">

</style>
