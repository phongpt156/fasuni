import { BASE_URL } from './';

export const AUTH = {
  index: BASE_URL + '/auth',
  login: BASE_URL + '/auth/login',
  logout: BASE_URL + '/auth/logout',
  register: BASE_URL + '/auth/register'
};

export const CITY = {
  getAll: BASE_URL + '/city'
};

export const FACEBOOK = {
  login: BASE_URL + '/auth/facebook/login'
};
