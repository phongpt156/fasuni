import httpClient from './../http';
import { handleError } from './../functions';
import { ATTRIBUTE } from './../constants/api';

export default {
  getAll() {
    return httpClient.get(ATTRIBUTE.getAll)
      .catch(handleError);
  }
};
