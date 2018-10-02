<template>
  <div class="lookbook-list">
    <div class="d-flex justify-content-center py-5" v-if="loading">
      <spinner :loading="loading"></spinner>
    </div>
    <div class="row mx-0" v-else>
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
import lookbookService from '@/shared/services/lookbook.service';
import Spinner from '@/components/shared/spinner/Spinner';

export default {
  components: {
    LookbookItem,
    Spinner
  },
  data() {
    return {
      lookbooks: [],
      loading: true
    };
  },
  computed: {
    month() {
      return this.$route.params.month;
    },
    year() {
      return this.$route.params.year;
    },
    gender() {
      return this.$route.params.gender;
    }
  },
  watch: {
    gender() {
      this.getLookbooks();
    },
    month() {
      this.getLookbooks();
    },
    year() {
      this.getLookbooks();
    }
  },
  methods: {
    getLookbooks() {
      this.loading = true;
      this.lookbooks = [];

      lookbookService.getLookbooksOfMonth(this.gender, this.year, this.month)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.lookbooks = response.data;
          }
          this.loading = false;
        });
    }
  },
  mounted() {
    this.getLookbooks();
  }
};
</script>

<style>

</style>
