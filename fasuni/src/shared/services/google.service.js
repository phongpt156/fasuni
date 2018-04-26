import httpClient from './../http';
import { handleError } from './../functions';
import { GOOGLE } from './../constants/api';

export default {
  login(body) {
    return httpClient.post(GOOGLE.login, body)
      .catch(handleError);
  }
};
