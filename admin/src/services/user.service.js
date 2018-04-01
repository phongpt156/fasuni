import { HTTP_CLIENT } from './../http';
import { USER } from './../constants/api';

import { handleError } from './../common/function';

export const USER_SERVICE = {
  login(data) {
    return HTTP_CLIENT.post(USER.login, data)
      .catch(handleError);
  },
  auth() {
    return HTTP_CLIENT.get(USER.auth)
      .catch(handleError);
  }
};
