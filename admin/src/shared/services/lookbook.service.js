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
  delete(id) {
    return httpClient.delete(`${LOOKBOOK.delete}${id}`)
      .catch(handleError);
  },
  getPrepareSaveName() {
    return httpClient.get(LOOKBOOK.getPrepareSaveName)
      .catch(handleError);
  },
  searchProducts() {
    return httpClient.get(LOOKBOOK.searchProducts)
      .catch(handleError);
  }
};
