import axios from 'axios';
import { BASE_URL } from './../constants';

const httpClient = axios.create({
  baseURL: BASE_URL,
  headers: {
    common: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'application/json'
    }
  }
});

httpClient.interceptors.request.use(function (config) {
  // Do something before request is sent
  config.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
  return config;
}, function (error) {
  // Do something with request error
  return Promise.reject(error);
});

export default httpClient;
