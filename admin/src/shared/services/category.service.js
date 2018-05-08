import httpClient from './../http';
import { handleError } from './../functions';
import { CATEGORY } from './../constants/api';

export default {
  getAll() {
    return httpClient.get(CATEGORY.getAll)
      .catch(handleError);
  }
};
