import httpClient from './../http';
import { handleError } from './../functions';
import { FACEBOOK } from './../constants/api';

export default {
  login(data) {
    return httpClient.post(FACEBOOK.login, data)
      .catch(handleError);
  }
};
