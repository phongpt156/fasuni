import axios from 'axios';
import constants from './../contants';
import actions from './actions';

const instance = axios.create({
  baseURL: constants.state.config.baseUrl,
  headers: {
    common: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'application/json'
    }
  }
});

instance.interceptors.request.use(function (config) {
  // Do something before request is sent
  config.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
  return config;
}, function (error) {
  // Do something with request error
  return Promise.reject(error);
});

export default {
  namespaced: true,
  state: {
    instance
  },
  actions
};
