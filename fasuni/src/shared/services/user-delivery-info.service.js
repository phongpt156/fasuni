import httpClient from './../http';
import { handleError } from './../functions';
import { USER_DELIVERY_INFO } from './../constants/api';

export default {
  getInfoOfUser() {
    return httpClient.get(USER_DELIVERY_INFO.getInfoOfUser)
      .catch(handleError);
  },
  store(body) {
    return httpClient.post(USER_DELIVERY_INFO.store, body)
      .catch(handleError);
  }
};
