import httpClient from './../http';
import { handleError } from './../functions';
import { AUTH } from './../constants/api';

export default {
  index() {
    return httpClient.get(AUTH.index)
      .catch(handleError);
  },
  login(data) {
    return httpClient.post(AUTH.login, data)
      .catch(handleError);
  },
  logout() {
    return httpClient.get(AUTH.logout)
      .catch(handleError);
  },
  register(data) {
    return httpClient.post(AUTH.register, data)
      .catch(handleError);
  }
};
