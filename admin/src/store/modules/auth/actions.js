import { USER_SERVICE } from './../../../services/user.service';

export default {
  index () {
    return new Promise(resolve => {
      USER_SERVICE.auth()
        .then(response => {
          resolve(response);
        });
    });
  }
};
