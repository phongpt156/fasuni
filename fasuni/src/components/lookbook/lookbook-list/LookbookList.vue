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
import lookbookService from '@/shared/services/lookbook.service';

export default {
  components: {
    LookbookItem
  },
  data() {
    return {
      lookbooks: []
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
  methods: {
    getLookbooks() {
      lookbookService.getLookbooksOfMonth(this.gender, this.year, this.month)
        .then(response => {
          if (response && response.status === 200 && response.data) {
            this.lookbooks = response.data;
          }
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
