import httpClient from './../http';
import { handleError } from './../functions';
import { DISTRICT } from './../constants/api';

export default {
  getWards(id) {
    return httpClient.get(`${DISTRICT.getWards}${id}`)
      .catch(handleError);
  }
};
