<template>
  <div class="product">
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
          title: 'Giá gốc',
          key: 'base_price',
          sortable: true,
          render: (h, params) => {
            return h('span', getFormatPrice(params.row.base_price));
          }
        },
        {
          title: 'Giá bán',
          key: 'inventories',
          sortable: true,
          sortMethod: (a, b, type) => {
            if (type === 'asc') {
              return a[0].sale_price - b[0].sale_price;
            }
            return b[0].sale_price - a[0].sale_price;
          },
          render: (h, params) => {
            return h('span', getFormatPrice(params.row.inventories[0].sale_price));
          }
        },
        {
          title: 'Tồn kho',
          key: 'quantity',
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
            return h('span', params.row.category && params.row.category.name);
          }
        }
      ]
    };
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
    }
  },
  mounted() {
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
