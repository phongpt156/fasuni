<template>
  <div class="product-list">
    <div class="row mx-2 mt-2">
      <div v-for="product in products" :key="product.id" class="col-xl-3 col-sm-6 px-2 my-2" v-if="products.length">
        <product-card :product="product"></product-card>
      </div>
      <div class="w-100 d-flex justify-content-center">
        <spinner class="mt-3" :loading="loading"></spinner>
      </div>
    </div>
  </div>
</template>

<script>
import ProductCard from './product-card/ProductCard';
import productService from '@/shared/services/product.service';
import { Pagination } from '@/shared/classes';
import Spinner from '@/components/shared/spinner/Spinner';

export default {
  name: 'ProductList',
  components: {
    ProductCard,
    Spinner
  },
  data() {
    return {
      loading: false,
      products: [
        // {
        //   id: 1,
        //   name: 'Figure crew as long as you love me',
        //   price: 1500000,
        //   image: 'https://images.allsaints.com/products/600/WO076N/5/WO076N-5-2.jpg',
        //   colors: [
        //     {
        //       id: 1,
        //       code: '#000'
        //     },
        //     {
        //       id: 2,
        //       code: '#7cc576'
        //     },
        //     {
        //       id: 3,
        //       code: '#fbced5'
        //     },
        //     {
        //       id: 4,
        //       code: '#ff00ff'
        //     },
        //     {
        //       id: 5,
        //       code: '#fff'
        //     }
        //   ],
        //   sizes: [
        //     {
        //       id: 1,
        //       name: 'XS',
        //       quantity: 0
        //     },
        //     {
        //       id: 2,
        //       name: 'S',
        //       quantity: 1
        //     },
        //     {
        //       id: 3,
        //       name: 'M',
        //       quantity: 1
        //     },
        //     {
        //       id: 4,
        //       name: 'L',
        //       quantity: 1
        //     },
        //     {
        //       id: 5,
        //       name: 'XL',
        //       quantity: 1
        //     },
        //     {
        //       id: 6,
        //       name: 'XXL',
        //       quantity: 1
        //     }
        //   ]
        // },
        // {
        //   id: 2,
        //   name: 'Figure crew as long as you love me',
        //   price: 1500000,
        //   image: 'https://images.allsaints.com/products/600/WO102N/5/WO102N-5-2.jpg',
        //   colors: [
        //     {
        //       id: 1,
        //       code: '#000'
        //     },
        //     {
        //       id: 2,
        //       code: '#7cc576'
        //     },
        //     {
        //       id: 3,
        //       code: '#fbced5'
        //     },
        //     {
        //       id: 4,
        //       code: '#ff00ff'
        //     },
        //     {
        //       id: 5,
        //       code: '#fff'
        //     }
        //   ],
        //   sizes: [
        //     {
        //       id: 1,
        //       name: 'XS'
        //     },
        //     {
        //       id: 2,
        //       name: 'S'
        //     },
        //     {
        //       id: 3,
        //       name: 'M'
        //     },
        //     {
        //       id: 4,
        //       name: 'L'
        //     },
        //     {
        //       id: 5,
        //       name: 'XL'
        //     },
        //     {
        //       id: 6,
        //       name: 'XXL'
        //     }
        //   ]
        // },
        // {
        //   id: 3,
        //   name: 'Figure crew as long as you love me',
        //   price: 1500000,
        //   image: 'https://images.allsaints.com/products/600/WM314N/451/WM314N-451-2.jpg',
        //   colors: [
        //     {
        //       id: 1,
        //       code: '#000'
        //     },
        //     {
        //       id: 2,
        //       code: '#7cc576'
        //     },
        //     {
        //       id: 3,
        //       code: '#fbced5'
        //     },
        //     {
        //       id: 4,
        //       code: '#ff00ff'
        //     },
        //     {
        //       id: 5,
        //       code: '#fff'
        //     }
        //   ],
        //   sizes: [
        //     {
        //       id: 1,
        //       name: 'XS'
        //     },
        //     {
        //       id: 2,
        //       name: 'S'
        //     },
        //     {
        //       id: 3,
        //       name: 'M'
        //     },
        //     {
        //       id: 4,
        //       name: 'L'
        //     },
        //     {
        //       id: 5,
        //       name: 'XL'
        //     },
        //     {
        //       id: 6,
        //       name: 'XXL'
        //     }
        //   ]
        // },
        // {
        //   id: 4,
        //   name: 'Figure crew as long as you love me',
        //   price: 1500000,
        //   image: 'https://images.allsaints.com/products/600/WO010N/5107/WO010N-5107-2.jpg',
        //   colors: [
        //     {
        //       id: 1,
        //       code: '#000'
        //     },
        //     {
        //       id: 2,
        //       code: '#7cc576'
        //     },
        //     {
        //       id: 3,
        //       code: '#fbced5'
        //     },
        //     {
        //       id: 4,
        //       code: '#ff00ff'
        //     },
        //     {
        //       id: 5,
        //       code: '#fff'
        //     }
        //   ],
        //   sizes: [
        //     {
        //       id: 1,
        //       name: 'XS'
        //     },
        //     {
        //       id: 2,
        //       name: 'S'
        //     },
        //     {
        //       id: 3,
        //       name: 'M'
        //     },
        //     {
        //       id: 4,
        //       name: 'L'
        //     },
        //     {
        //       id: 5,
        //       name: 'XL'
        //     },
        //     {
        //       id: 6,
        //       name: 'XXL'
        //     }
        //   ]
        // },
        // {
        //   id: 5,
        //   name: 'Figure crew as long as you love me',
        //   price: 1500000,
        //   image: 'https://images.allsaints.com/products/600/WO052N/2824/WO052N-2824-2.jpg',
        //   colors: [
        //     {
        //       id: 1,
        //       code: '#000'
        //     },
        //     {
        //       id: 2,
        //       code: '#7cc576'
        //     },
        //     {
        //       id: 3,
        //       code: '#fbced5'
        //     },
        //     {
        //       id: 4,
        //       code: '#ff00ff'
        //     },
        //     {
        //       id: 5,
        //       code: '#fff'
        //     }
        //   ],
        //   sizes: [
        //     {
        //       id: 1,
        //       name: 'XS'
        //     },
        //     {
        //       id: 2,
        //       name: 'S'
        //     },
        //     {
        //       id: 3,
        //       name: 'M'
        //     },
        //     {
        //       id: 4,
        //       name: 'L'
        //     },
        //     {
        //       id: 5,
        //       name: 'XL'
        //     },
        //     {
        //       id: 6,
        //       name: 'XXL'
        //     }
        //   ]
        // },
        // {
        //   id: 6,
        //   name: 'Figure crew as long as you love me',
        //   price: 1500000,
        //   image: 'https://images.allsaints.com/products/600/WO060N/4351/WO060N-4351-2.jpg',
        //   colors: [
        //     {
        //       id: 1,
        //       code: '#000'
        //     },
        //     {
        //       id: 2,
        //       code: '#7cc576'
        //     },
        //     {
        //       id: 3,
        //       code: '#fbced5'
        //     },
        //     {
        //       id: 4,
        //       code: '#ff00ff'
        //     },
        //     {
        //       id: 5,
        //       code: '#fff'
        //     }
        //   ],
        //   sizes: [
        //     {
        //       id: 1,
        //       name: 'XS'
        //     },
        //     {
        //       id: 2,
        //       name: 'S'
        //     },
        //     {
        //       id: 3,
        //       name: 'M'
        //     },
        //     {
        //       id: 4,
        //       name: 'L'
        //     },
        //     {
        //       id: 5,
        //       name: 'XL'
        //     },
        //     {
        //       id: 6,
        //       name: 'XXL'
        //     }
        //   ]
        // },
        // {
        //   id: 7,
        //   name: 'Figure crew as long as you love me',
        //   price: 1500000,
        //   image: 'https://images.allsaints.com/products/600/WO085N/5226/WO085N-5226-2.jpg',
        //   colors: [
        //     {
        //       id: 1,
        //       code: '#000'
        //     },
        //     {
        //       id: 2,
        //       code: '#7cc576'
        //     },
        //     {
        //       id: 3,
        //       code: '#fbced5'
        //     },
        //     {
        //       id: 4,
        //       code: '#ff00ff'
        //     },
        //     {
        //       id: 5,
        //       code: '#fff'
        //     }
        //   ],
        //   sizes: [
        //     {
        //       id: 1,
        //       name: 'XS'
        //     },
        //     {
        //       id: 2,
        //       name: 'S'
        //     },
        //     {
        //       id: 3,
        //       name: 'M'
        //     },
        //     {
        //       id: 4,
        //       name: 'L'
        //     },
        //     {
        //       id: 5,
        //       name: 'XL'
        //     },
        //     {
        //       id: 6,
        //       name: 'XXL'
        //     }
        //   ]
        // },
        // {
        //   id: 8,
        //   name: 'Figure crew as long as you love me',
        //   price: 1500000,
        //   image: 'https://images.allsaints.com/products/600/WO062N/3836/WO062N-3836-2.jpg',
        //   colors: [
        //     {
        //       id: 1,
        //       code: '#000'
        //     },
        //     {
        //       id: 2,
        //       code: '#7cc576'
        //     },
        //     {
        //       id: 3,
        //       code: '#fbced5'
        //     },
        //     {
        //       id: 4,
        //       code: '#ff00ff'
        //     },
        //     {
        //       id: 5,
        //       code: '#fff'
        //     }
        //   ],
        //   sizes: [
        //     {
        //       id: 1,
        //       name: 'XS'
        //     },
        //     {
        //       id: 2,
        //       name: 'S'
        //     },
        //     {
        //       id: 3,
        //       name: 'M'
        //     },
        //     {
        //       id: 4,
        //       name: 'L'
        //     },
        //     {
        //       id: 5,
        //       name: 'XL'
        //     },
        //     {
        //       id: 6,
        //       name: 'XXL'
        //     }
        //   ]
        // },
        // {
        //   id: 9,
        //   name: 'Figure crew as long as you love me',
        //   price: 1500000,
        //   image: 'https://images.allsaints.com/products/600/WO010N/5107/WO010N-5107-2.jpg',
        //   colors: [
        //     {
        //       id: 1,
        //       code: '#000'
        //     },
        //     {
        //       id: 2,
        //       code: '#7cc576'
        //     },
        //     {
        //       id: 3,
        //       code: '#fbced5'
        //     },
        //     {
        //       id: 4,
        //       code: '#ff00ff'
        //     },
        //     {
        //       id: 5,
        //       code: '#fff'
        //     }
        //   ],
        //   sizes: [
        //     {
        //       id: 1,
        //       name: 'XS'
        //     },
        //     {
        //       id: 2,
        //       name: 'S'
        //     },
        //     {
        //       id: 3,
        //       name: 'M'
        //     },
        //     {
        //       id: 4,
        //       name: 'L'
        //     },
        //     {
        //       id: 5,
        //       name: 'XL'
        //     },
        //     {
        //       id: 6,
        //       name: 'XXL'
        //     }
        //   ]
        // }
      ],
      pagination: new Pagination()
    };
  },
  methods: {
    getProducts(page) {
      if (!this.loading) {
        this.loading = true;

        productService.getAll(page)
          .then(response => {
            if (response && response.status === 200 && response.data) {
              if (this.products.length) {
                this.products = this.products.concat(response.data.data);
              } else {
                this.products = response.data.data;
              }
              if (!response.data.next_page_url) {
                document.removeEventListener('scroll', this.onScroll);
              }

              this.pagination.total = response.data.total;
              this.pagination.current = response.data.current_page;
              this.pagination.perPage = response.data.per_page;
              this.loading = false;
            }
          });
      }
    },
    onScroll() {
      const footerHeight = document.querySelector('.footer').offsetHeight;

      if (document.documentElement.scrollTop + window.innerHeight >= document.documentElement.scrollHeight - footerHeight) {
        this.getProducts(this.pagination.current + 1);
      }
    }
  },
  mounted() {
    this.getProducts(this.$route.params.type, 1);
    document.addEventListener('scroll', this.onScroll, {
      passive: true
    });
  },
  destroyed() {
    document.removeEventListener('scroll', this.onScroll);
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.product-list {
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .fa-spinner {
    font-size: 2rem;
    animation: spin 2s linear infinite;
  }
}
</style>
