import httpClient from './../http';
import { handleError } from './../functions';
import { COLLECTION } from './../constants/api';

export default {
  getAll() {
    return httpClient.get(COLLECTION.getAll)
      .catch(handleError);
  },
  store(body) {
    return httpClient.post(COLLECTION.store, body)
      .catch(handleError);
  }
};
