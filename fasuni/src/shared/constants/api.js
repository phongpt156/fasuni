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

export const GOOGLE = {
  login: BASE_URL + '/auth/google/login'
};

export const CATEGORY = {
  getAll: BASE_URL + '/category'
};

export const PRODUCT = {
  getAll: BASE_URL + '/product',
  getOne: BASE_URL + '/product/',
  getByCategory: BASE_URL + '/product/category/'
};

export const USER_PRODUCT_COMMUNICATION = {
  like: BASE_URL + '/like-product/',
  dislike: BASE_URL + '/dislike-product/'
};

export const LOOKBOOK = {
  getMaleMonthListSnapshot: BASE_URL + '/lookbook/get-male-month-list-snapshot',
  getFemaleMonthListSnapshot: BASE_URL + '/lookbook/get-female-month-list-snapshot'
};

export const ATTRIBUTE_VALUE = {
  getColors: BASE_URL + '/attribute-value/color',
  getSizes: BASE_URL + '/attribute-value/size'
};
