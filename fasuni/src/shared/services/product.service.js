import httpClient from './../http';
import { handleError } from './../functions';
import { PRODUCT } from './../constants/api';

export default {
  getAll(type, page = 1) {
    return httpClient.get(`${PRODUCT.getAll}?type=${type}&page=${page}`)
      .catch(handleError);
  },
  getOne(id) {
    return httpClient.get(`${PRODUCT.getOne}${id}`)
      .catch(handleError);
  },
  getByCategory(filters, page = 1) {
    return httpClient.get(`${PRODUCT.getByCategory}${filters.category}?type=${filters.type}&page=${page}`)
      .catch(handleError);
  }
};
