import httpClient from './../http';
import { handleError } from './../functions';
import { FACEBOOK } from './../constants/api';

export default {
  login(body) {
    return httpClient.post(FACEBOOK.login, body)
      .catch(handleError);
  }
};
