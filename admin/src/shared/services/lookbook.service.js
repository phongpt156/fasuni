import httpClient from './../http';
import { handleError } from './../functions';
import { LOOKBOOK } from './../constants/api';

export default {
  getAll() {
    return httpClient.get(LOOKBOOK.getAll)
      .catch(handleError);
  },
  store(body) {
    return httpClient.post(LOOKBOOK.store, body)
      .catch(handleError);
  },
  getPrepareSaveName(page = 1) {
    return httpClient.get(LOOKBOOK.getPrepareSaveName)
      .catch(handleError);
  }
};