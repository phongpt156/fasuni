import axios from 'axios';
import { API_BASE_URL } from './../constants';

const httpClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    common: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'application/json',
    },
  },
});

httpClient.interceptors.request.use(config => {
  // Do something before request is sent
  const token = localStorage.getItem('token');

  if (token) {
    config.headers.common['Authorization'] = `Bearer ${token}`;
  }
  return config;
}, function (error) {
  // Do something with request error
  return Promise.reject(error);
});

export default httpClient;
