<template>
  <div class="customer">
    <i-table
      :data="customers"
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
import customerService from '@/shared/services/customer.service';
import { Pagination } from '@/shared/classes';
import { formatGender } from '@/filters';

export default {
  data() {
    return {
      loading: true,
      customers: [],
      pagination: new Pagination(),
      hasPagination: false,
      columns: [
        {
          title: 'Mã khách hàng',
          key: 'code',
          sortable: true
        },
        {
          title: 'Tên',
          key: 'name',
          sortable: true
        },
        {
          title: 'Số điện thoại',
          key: 'phone_number',
          sortable: true
        },
        {
          title: 'Địa chỉ',
          key: 'address',
          sortable: true
        },
        {
          title: 'Email',
          key: 'email',
          sortable: true
        },
        {
          title: 'Giới tính',
          key: 'gender',
          sortable: true,
          render: (h, params) => {
            return h('span', formatGender(params.row.gender));
          }
        }
      ]
    };
  },
  methods: {
    getCustomers(page = 1) {
      customerService.getAll(page = 1)
        .then(response => {
          if (response.status === 200 && response.data && response.data.data) {
            this.customers = response.data.data;
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
    changePage(page) {
      this.getCustomers(page);
    }
  },
  mounted() {
    this.getCustomers();
  }
};
</script>

<style lang="scss">

</style>
