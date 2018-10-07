<template>
  <div class="banner">
    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;visibility:hidden;">
      <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;">
        <div>
          <a>
            <img data-u="image" :src="`${imageUrl}/Slider1.jpg`" />
          </a>
        </div>
        <div>
          <a>
            <img data-u="image" :src="`${imageUrl}/Slider2.jpg`" />
          </a>
        </div>
        <div>
          <a>
            <img data-u="image" :src="`${imageUrl}/Slider3.jpg`" />
          </a>
        </div>
        <div>
          <a>
            <img data-u="image" :src="`${imageUrl}/Slider4.jpg`" />
          </a>
        </div>
      </div>
      <!-- Arrow Navigator -->
      <div data-u="arrowleft" class="jssora051" style="width:45px;height:45px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;" class="d-flex align-items-center shadow justify-content-center bg-white">
          <font-awesome-icon :icon="icons.angleLeft"></font-awesome-icon>
        </div>
      </div>
      <div data-u="arrowright" class="jssora051" style="width:45px;height:45px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;" class="d-flex align-items-center shadow justify-content-center bg-white">
          <font-awesome-icon :icon="icons.angleRight"></font-awesome-icon>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import angleLeftIcon from '@fortawesome/fontawesome-free-solid/faAngleLeft';
import angleRightIcon from '@fortawesome/fontawesome-free-solid/faAngleRight';
import { IMAGE_URL } from '@/shared/constants';

export default {
  components: {
    FontAwesomeIcon,
  },
  data() {
    return {
      icons: {
        angleLeft: angleLeftIcon,
        angleRight: angleRightIcon,
      },
      loading: true,
    };
  },
  computed: {
    JssorSlider() {
      return window.$JssorSlider$;
    },
    imageUrl() {
      return IMAGE_URL;
    },
  },
  methods: {
    initJssorSlider() {
      const jssorSlideoTransitions = [
        [{
          b: -1,
          d: 1,
          o: -0.7,
        }],
        [{
          b: 900,
          d: 2000,
          x: -379,
          e: {
            x: 7,
          },
        }],
        [{
          b: 900,
          d: 2000,
          x: -379,
          e: {
            x: 7,
          },
        }],
        [
          {
            b: -1,
            d: 1,
            o: -1,
            sX: 2,
            sY: 2,
          },
          {
            b: 0,
            d: 900,
            x: -171,
            y: -341,
            o: 1,
            sX: -2,
            sY: -2,
            e: {
              x: 3,
              y: 3,
              sX: 3,
              sY: 3,
            },
          },
          {
            b: 900,
            d: 1600,
            x: -283,
            o: -1,
            e: {
              x: 16,
            },
          },
        ],
      ];

      const jssorOptions = {
        $AutoPlay: 1,
        $SlideDuration: 2000,
        $SlideEasing: window.$Jease$.$OutQuint,
        $CaptionSliderOptions: {
          $Class: window.$JssorCaptionSlideo$,
          $Transitions: jssorSlideoTransitions,
        },
        $ArrowNavigatorOptions: {
          $Class: window.$JssorArrowNavigator$,
        },
      };

      const jssorSlider = new this.JssorSlider('jssor_1', jssorOptions);

      const MAX_WIDTH = 3000;

      function scaleSlider() {
        const containerElement = jssorSlider.$Elmt.parentNode;
        const containerWidth = containerElement.clientWidth;

        if (containerWidth) {
          const expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

          jssorSlider.$ScaleWidth(expectedWidth);
        } else {
          window.setTimeout(scaleSlider, 30);
        }
      }

      scaleSlider(jssorSlider);

      window.$Jssor$.$AddEvent(window, 'load', scaleSlider);
      window.$Jssor$.$AddEvent(window, 'resize', scaleSlider);
      window.$Jssor$.$AddEvent(window, 'orientationchange', scaleSlider);
    },
  },
  mounted() {
    this.initJssorSlider();
  },
};
</script>

<style lang="scss">
.jssora051 {
  position:absolute;
  display:block;
  cursor:pointer;

  .shadow {
    border-radius: 50%;
  }

  svg {
    font-size: 28px;
  }
}
</style>
