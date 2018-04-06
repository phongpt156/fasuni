import httpClient from './../http';
import { handleError } from './../functions';
import { AUTH } from './../constants/api';

export default {
  login(data) {
    return httpClient.post(AUTH.login, data)
      .catch(handleError);
  },
  index() {
    return httpClient.get(AUTH.index)
      .catch(handleError);
  }
};
