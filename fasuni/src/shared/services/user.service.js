import httpClient from './../http';
import { handleError } from './../functions';
import { AUTH, USER } from './../constants/api';

export default {
  index() {
    return httpClient.get(AUTH.index)
      .catch(handleError);
  },
  login(body) {
    return httpClient.post(AUTH.login, body)
      .catch(handleError);
  },
  logout() {
    return httpClient.get(AUTH.logout)
      .catch(handleError);
  },
  register(body) {
    return httpClient.post(AUTH.register, body)
      .catch(handleError);
  },
  getWhistlist(page = 1) {
    return httpClient.get(`${USER.getWhistlist}?page=${page}`)
      .catch(handleError);
  }
};
