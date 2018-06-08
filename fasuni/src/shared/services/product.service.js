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
    let url = `${PRODUCT.getByCategory}${filters.category}`;
    if (!filters.type) {
      filters.type = 'newest';
    }
    url += `?type=${filters.type}`;
    if (filters.colors) {
      url += `&colors=${filters.colors}`;
    }
    if (filters.sizes) {
      url += `&sizes=${filters.sizes}`;
    }
    url += `&page=${page}`;

    return httpClient.get(url)
      .catch(handleError);
  },
  getRelevant(id, categoryId, page = 1) {
    return httpClient.get(`${PRODUCT.getRelevant}${id}?category=${categoryId}&page=${page}`)
      .catch(handleError);
  }
};
