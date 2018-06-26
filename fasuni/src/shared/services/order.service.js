import httpClient from './../http';
import { handleError } from './../functions';
import { ORDER } from './../constants/api';

export default {
  store(body) {
    return httpClient.post(ORDER.store, body)
      .catch(handleError);
  },
  getOne(id) {
    return httpClient.get(`${ORDER.getOne}${id}`)
      .catch(handleError);
  },
  getOrderHistoriesOfUser() {
    return httpClient.get(ORDER.getOrderHistoriesOfUser)
      .catch(handleError);
  },
  delete(id) {
    return httpClient.delete(`${ORDER.delete}${id}`)
      .catch(handleError);
  }
};
