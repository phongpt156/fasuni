import Vue from 'vue';
import VueProgressBar from 'vue-progressbar';

const options = {
  color: '#42b983',
  failedColor: '#874b4b',
  thickness: '1px',
  transition: {
    speed: '0.6s',
    opacity: '0.6s',
    termination: 400
  },
  autoRevert: true,
  location: 'top',
  inverse: false
};

Vue.use(VueProgressBar, options);
