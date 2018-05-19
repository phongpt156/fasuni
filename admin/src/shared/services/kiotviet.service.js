import httpClient from './../http';
import { handleError } from './../functions';
import { KIOTVIET } from './../constants/api';

export default {
  sync() {
    return httpClient.get(KIOTVIET.sync)
      .catch(handleError);
  }
};
