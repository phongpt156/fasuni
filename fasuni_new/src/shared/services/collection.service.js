import httpClient from './../http';
import { handleError } from './../functions';
import { COLLECTION } from './../constants/api';

export default {
  getAll() {
    return httpClient.get(COLLECTION.getAll)
      .catch(handleError);
  },
  getOne(id) {
    return httpClient.get(`${COLLECTION.getOne}${id}`)
      .catch(handleError);
  }
};
