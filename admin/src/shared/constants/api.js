import { BASE_URL } from './';

export const AUTH = {
  index: BASE_URL + '/auth',
  login: BASE_URL + '/auth/login'
};

export const CATEGORY = {
  getAll: BASE_URL + '/category'
};

export const PRODUCT = {
  getAll: BASE_URL + '/product',
  search: BASE_URL + '/product/search',
  update: BASE_URL + '/product/'
};

export const ATTRIBUTE = {
  getAll: BASE_URL + '/attribute'
};

export const CUSTOMER = {
  getAll: BASE_URL + '/customer'
};

export const KIOTVIET = {
  sync: BASE_URL + '/kiotviet/sync'
};

export const IMAGE = {
  upload: BASE_URL + '/image/upload',
  uploadLookbook: BASE_URL + '/image/upload/lookbook',
  uploadCollection: BASE_URL + '/image/upload/collection',
  delete: BASE_URL + '/image/delete/'
};

export const LOOKBOOK = {
  getAll: BASE_URL + '/lookbook',
  store: BASE_URL + '/lookbook',
  delete: BASE_URL + '/lookbook/',
  getPrepareSaveName: BASE_URL + '/lookbook/get-prepare-save-name',
  searchProducts: BASE_URL + '/lookbook/search-product'
};

export const COLLECTION = {
  getAll: BASE_URL + '/collection',
  store: BASE_URL + '/collection'
};
