<template>
  <div class="lookbook-archive">
    <p class="h5 text-center mb-0 py-4 text-uppercase">The Lookbook</p>
    <hr class="m-0" />
    <p class="text-center mb-0 py-3 description">The Lookbook by month. A curated journal of collections, past and present. Choose a Lookbook below to browse and shop the featured items</p>
    <div>
      <div class="row mx-0 lookbook-list-wrapper max-md-950-height">
        <div class="col-md-6 pr-0 py-2 pl-3">
          <div class="lookbook-item h-100">
            <a class="d-block h-100">
              <img :src="lookbooks[0].image" alt="" class="h-100 w-100" />
            </a>
            <div class="content d-flex align-items-center justify-content-center h-100">
              <div>
                <h4 class="text-uppercase mb-0">{{ lookbooks[0].date }}</h4>
                <p class="text-center view-now-button">View Now</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 pl-2 pr-1">
          <div class="row mx-0 h-100">
            <div class="col-sm-6 p-2 h-50" v-for="lookbook in notCurrentMonthLookbooks" :key="lookbook.id">
              <div class="lookbook-item h-100">
                <a class="d-block h-100">
                  <img :src="lookbook.image" alt="" class="h-100 w-100" />
                </a>
                <div class="content d-flex align-items-end justify-content-center h-100">
                  <div>
                    <h4 class="text-uppercase mb-0">{{ lookbook.date }}</h4>
                    <p class="text-center view-now-button">View Now</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <fieldset class="view-archive mx-2 my-3">
      <legend align="center">
        <a class="view-archive-button py-2 px-3 d-flex align-items-center" @click="isDisplayMoreLookbook = !isDisplayMoreLookbook">
          View Archive
          <font-awesome-icon class="ml-2" :icon="icons.angleDown" v-if="isDisplayMoreLookbook"></font-awesome-icon>
          <font-awesome-icon class="ml-2" :icon="icons.angleRight" v-else></font-awesome-icon>
        </a>
      </legend>
    </fieldset>
    <div v-show="isDisplayMoreLookbook" class="lookbook-list-wrapper">
      <div class="row mx-0">
        <div class="col-md-3 col-sm-6 p-2" v-for="lookbook in moreLookbooks" :key="lookbook.id">
          <div class="lookbook-item">
            <a class="d-block">
              <img :src="lookbook.image" alt="" class="w-100 h-100" />
            </a>
            <div class="content d-flex align-items-end justify-content-center h-100">
              <div>
                <h4 class="text-uppercase mb-0">{{ lookbook.date }}</h4>
                <p class="text-center view-now-button">View Now</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <fieldset class="view-archive mx-2 my-3" v-if="isDisplayMoreLookbook">
      <legend align="center">
        <a class="view-archive-button py-2 px-3 d-flex align-items-center">
          Show More
          <font-awesome-icon class="ml-2" :icon="icons.angleDown"></font-awesome-icon>
        </a>
      </legend>
    </fieldset>
  </div>
</template>

<script>
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import angleDownIcon from '@fortawesome/fontawesome-free-solid/faAngleDown';
import angleRightIcon from '@fortawesome/fontawesome-free-solid/faAngleRight';

export default {
  components: {
    FontAwesomeIcon
  },
  data() {
    return {
      isDisplayMoreLookbook: false,
      icons: {
        angleDown: angleDownIcon,
        angleRight: angleRightIcon
      },
      lookbooks: [
        {
          id: 1,
          date: 'Tháng 3 2018',
          image: 'https://images.allsaints.com/static/900/HP-MARCH-2018-WW-01.jpg'
        },
        {
          id: 2,
          date: 'Tháng 2 2018',
          image: 'https://images.allsaints.com/static/320/HP-Feb-2018-WW-01.jpg'
        },
        {
          id: 3,
          date: 'Tháng 1 2018',
          image: 'https://images.allsaints.com/static/320/HP_Jan_2018_WW_01.jpg'
        },
        {
          id: 4,
          date: 'Tháng 12 2017',
          image: 'https://images.allsaints.com/static/320/HP_Oct_WW_01.jpg'
        },
        {
          id: 5,
          date: 'Tháng 11 2017',
          image: 'https://images.allsaints.com/static/320/HP_Sep_WW_01.jpg'
        }
      ],
      currentMonthLookbook: {},
      notCurrentMonthLookbooks: [],
      moreLookbooks: [
        {
          id: 6,
          date: 'Tháng 10 2017',
          image: 'https://images.allsaints.com/static/320/HP_Aug_WW_01-V2.jpg'
        },
        {
          id: 7,
          date: 'Tháng 10 2017',
          image: 'https://images.allsaints.com/static/320/HP_Jun_WW_01.jpg'
        },
        {
          id: 8,
          date: 'Tháng 9 2017',
          image: 'https://images.allsaints.com/static/320/HP_May_WW_01.jpg'
        },
        {
          id: 9,
          date: 'Tháng 8 2017',
          image: 'https://images.allsaints.com/static/320/HP_Apr_WW_01.jpg'
        },
        {
          id: 10,
          date: 'Tháng 7 2017',
          image: 'https://images.allsaints.com/static/320/HP-Mar_WW_01.jpg'
        },
        {
          id: 11,
          date: 'Tháng 5 2017',
          image: 'https://images.allsaints.com/static/320/February_2017_WW_01.jpg'
        },
        {
          id: 12,
          date: 'Tháng 4 2017',
          image: 'https://images.allsaints.com/static/320/January_2017_WW_01.jpg'
        },
        {
          id: 13,
          date: 'Tháng 3 2017',
          image: 'https://images.allsaints.com/static/320/Selfridges_LTD_01.jpg'
        }
      ]
    };
  },
  mounted() {
    this.currentMonthLookbook = this.lookbooks[0];
    this.notCurrentMonthLookbooks = this.lookbooks.slice().splice(1);
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/functions';
@import '~bootstrap/scss/_variables';
@import '~bootstrap/scss/bootstrap-grid';

.lookbook-archive {
  hr {
    border-top: 1px solid $black;
  }
  .description {
    color: #252525;
  }
  .view-archive {
    position: relative;
  }
  .view-archive-button {
    transition: all .3s ease-in-out 0s;
    position: relative;
    font-size: $font-size-base;
    border: 1px solid #4d4d4d;

    &:hover {
      color: $white !important;
      border-color: $black;
      background-color: $black;
    }
  }
  fieldset {
    border-top: 1px solid #4d4d4d;
  }
  legend {
    width: auto;
  }
  .lookbook-item {
    position: relative;
    cursor: pointer;

    &:hover {
      &:after {
        transition: opacity .15s ease 0s;
        opacity: 1;
      }

      .view-now-button {
        visibility: visible;
      }
    }
    &:after {
      width: 100%;
      top: 0;
      transition: opacity .22s ease .22s;
      position: absolute;
      opacity: 0;
      left: 0;
      height: 100%;
      display: block;
      content: "";
      background: none repeat scroll 0 0 rgba(0, 0, 0, 0.35);
    }

    .content {
      z-index: 1000;
      top: 0;
      transition: all linear .2s;
      right: -1px;
      position: absolute;
      overflow: hidden;
      left: 0;
      color: rgba(255, 255, 255, .8);
      bottom: -1px;
    }
    .view-now-button {
      visibility: hidden;
    }
  }

  @include media-breakpoint-up(md) {
    .max-md-950-height {
      max-height: 950px;
    }
  }
}
</style>
