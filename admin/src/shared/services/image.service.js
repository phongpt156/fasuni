import httpClient from './../http';
import { handleError } from './../functions';
import { IMAGE } from './../constants/api';

export default {
  upload() {
    return httpClient.post(IMAGE.upload)
      .catch(handleError);
  },
  delete(url) {
    return httpClient.delete(`${IMAGE.delete}${url}`)
      .catch(handleError);
  }
};
