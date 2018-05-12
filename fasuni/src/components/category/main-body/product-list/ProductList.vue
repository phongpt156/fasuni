<template>
  <div class="product-list">
    <div class="row mx-2 mt-2">
      <template v-if="loading">
        Loading...
      </template>
      <template v-else>
        <div v-for="product in products" :key="product.id" class="col-xl-3 col-sm-6 px-2 my-2">
          <product-card :product="product"></product-card>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import ProductCard from './product-card/ProductCard';
import productService from '@/shared/services/product.service';

export default {
  name: 'ProductList',
  components: {
    ProductCard
  },
  data() {
    return {
      loading: true,
      products: [
        {
          id: 1,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/WO076N/5/WO076N-5-2.jpg',
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
          image: 'https://images.allsaints.com/products/600/WO102N/5/WO102N-5-2.jpg',
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
          image: 'https://images.allsaints.com/products/600/WM314N/451/WM314N-451-2.jpg',
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
          image: 'https://images.allsaints.com/products/600/WO010N/5107/WO010N-5107-2.jpg',
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
          id: 5,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/WO052N/2824/WO052N-2824-2.jpg',
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
          id: 6,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/WO060N/4351/WO060N-4351-2.jpg',
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
          id: 7,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/WO085N/5226/WO085N-5226-2.jpg',
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
          id: 8,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/WO062N/3836/WO062N-3836-2.jpg',
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
          id: 9,
          name: 'Figure crew as long as you love me',
          price: 1500000,
          image: 'https://images.allsaints.com/products/600/WO010N/5107/WO010N-5107-2.jpg',
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
  },
  methods: {
    getProducts(page) {
      productService.getAll(page)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.products = response.data.data;
            this.loading = false;
          }
        });
    }
  },
  mounted() {
    this.getProducts(1);
    document.addEventListener('scroll', function () {
      console.log(document.documentElement.scrollTop);
    }, {
      passive: true
    });
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">

</style>
