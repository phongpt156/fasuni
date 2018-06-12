import httpClient from './../http';
import { handleError } from './../functions';
import { PRODUCT } from './../constants/api';

export default {
  getAll(page = 1) {
    return httpClient.get(`${PRODUCT.getAll}?page=${page}`)
      .catch(handleError);
  },
  search(query = {}) {
    let url = PRODUCT.search;

    if (query.name) {
      url += `?name=${query.name}`;
    }

    return httpClient.get(url)
      .catch(handleError);
  },
  update(id, body) {
    return httpClient.put(`${PRODUCT.update}${id}`, body)
      .catch(handleError);
  }
};
