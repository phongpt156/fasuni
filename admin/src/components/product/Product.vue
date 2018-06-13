<template>
  <div class="product">
    <i-input v-model="name" placeholder="Tìm kiếm sản phẩm" class="mb-3 w-25"></i-input>
    <i-table
      :data="products"
      :columns="columns"
      :loading="loading">
    </i-table>
    <div class="mt-3" v-if="hasPagination">
      <page
        :total="pagination.total"
        :current="pagination.current"
        :page-size="pagination.perPage"
        @on-change="changePage"
        class="d-flex justify-content-end"
        size="small"></page>
    </div>
  </div>
</template>

<script>
import productService from '@/shared/services/product.service';
import attributeService from '@/shared/services/attribute.service';
import { getFormatPrice } from '@/shared/functions';
import ProductDetail from './ProductDetail';
import { Pagination } from '@/shared/classes';
import _ from 'lodash';

export default {
  components: {
    ProductDetail
  },
  data() {
    return {
      loading: true,
      pagination: new Pagination(),
      hasPagination: false,
      products: [],
      attributes: [],
      name: '',
      columns: [
        {
          type: 'expand',
          expanded: true,
          width: 50,
          render: (h, params) => {
            return h(ProductDetail, {
              props: {
                product: params.row,
                attributes: this.attributes
              }
            });
          }
        },
        {
          title: 'Mã sản phẩm',
          key: 'code',
          sortable: true
        },
        {
          title: 'Tên',
          key: 'name',
          sortable: true
        },
        {
          title: 'Giá bán',
          key: 'sale_price',
          sortable: true,
          render: (h, params) => {
            return h('span', getFormatPrice(params.row.sale_price));
          }
        },
        {
          align: 'center',
          title: 'Tồn kho',
          key: 'total_quantity',
          sortable: true
        },
        {
          title: 'Nhóm sản phẩm',
          key: 'category',
          sortable: true,
          sortMethod: (a, b, type) => {
            if (type === 'asc') {
              return a.name - b.name;
            }
            return b.name - a.name;
          },
          render: (h, params) => {
            let name = '';

            if (params.row.category) {
              name += params.row.category.name;

              let parent = params.row.category.parent;

              while (parent) {
                name += ` << ${parent.name}`;
                parent = parent.parent;
              }
            }

            return h('span', name);
          }
        },
        {
          align: 'center',
          title: 'Hiển thị ra web',
          key: 'is_display',
          sortable: true,
          render: (h, params) => {
            return h('Checkbox', {
              props: {
                value: Boolean(Number(params.row.is_display))
              },
              on: {
                'on-change': (value) => {
                  params.row.is_display = value;
                  this.updateProduct(params.row);
                }
              }
            });
          }
        }
      ],
      makeSearchRequest: ''
    };
  },
  watch: {
    name(newValue) {
      this.makeSearchRequest(newValue);
    }
  },
  methods: {
    getProducts(page = 1) {
      this.loading = true;
      productService.getAll(page)
        .then(response => {
          if (response.status === 200 && response.data && response.data.data) {
            this.products = response.data.data;
            this.loading = false;
            if (response.data.next_page_url) {
              this.hasPagination = true;
            }
            this.pagination.total = response.data.total;
            this.pagination.current = response.data.current_page;
            this.pagination.perPage = response.data.per_page;
          }
        });
    },
    getAttributes() {
      attributeService.getAll()
        .then(response => {
          if (response.status === 200 && response.data) {
            this.attributes = response.data;
          }
        });
    },
    changePage(page) {
      this.getProducts(page);
    },
    updateProduct(product) {
      productService.update(product.id, product);
    },
    search(name) {
      this.loading = true;

      productService.search({
        name
      }).then(response => {
        if (response && response.status === 200 && response.data) {
          this.products = response.data.data;

          this.loading = false;
          if (response.data.next_page_url) {
            this.hasPagination = true;
          }
          this.pagination.total = response.data.total;
          this.pagination.current = response.data.current_page;
          this.pagination.perPage = response.data.per_page;
        }
      });
    }
  },
  mounted() {
    this.makeSearchRequest = _.debounce(name => {
      this.search(name);
    }, 300);

    this.getProducts();
    this.getAttributes();
  }
};
</script>

<style lang="scss">
.product {
  .ivu-page-item {
    transition: unset;
    color: #000;

    &-active {
      color: #fff;
    }

    a {
      transition: unset;
    }
  }
  .ivu-table-expanded-cell {
    padding: 20px;
  }
}
</style>
