import httpClient from './../http';
import { handleError } from './../functions';
import { GOOGLE } from './../constants/api';

export default {
  login(data) {
    return httpClient.post(GOOGLE.login, data)
      .catch(handleError);
  }
};
