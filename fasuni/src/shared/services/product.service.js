import httpClient from './../http';
import { handleError } from './../functions';
import { PRODUCT } from './../constants/api';

export default {
  getAll(page = 1) {
    return httpClient.get(`${PRODUCT.getAll}?page=${page}`)
      .catch(handleError);
  },
  getOne(slug) {
    return httpClient.get(`${PRODUCT.getOne}${slug}`)
      .catch(handleError);
  }
};
