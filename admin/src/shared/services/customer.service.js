import httpClient from './../http';
import { handleError } from './../functions';
import { CUSTOMER } from './../constants/api';

export default {
  getAll(page = 1) {
    return httpClient.get(`${CUSTOMER.getAll}?page=${page}`)
      .catch(handleError);
  }
};
