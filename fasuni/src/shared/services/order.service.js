import httpClient from './../http';
import { handleError } from './../functions';
import { ORDER } from './../constants/api';

export default {
  store(body) {
    return httpClient.post(ORDER.store, body)
      .catch(handleError);
  }
};
