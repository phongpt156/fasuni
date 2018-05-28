import httpClient from './../http';
import { handleError } from './../functions';
import { IMAGE } from './../constants/api';

export default {
  upload() {
    return httpClient.get(IMAGE.upload)
      .catch(handleError);
  }
};
