import httpClient from './../http';
import { handleError } from './../functions';
import { ATTRIBUTE_VALUE } from './../constants/api';

export default {
  getColors() {
    return httpClient.get(ATTRIBUTE_VALUE.getColors)
      .catch(handleError);
  },
  getSizes() {
    return httpClient.get(ATTRIBUTE_VALUE.getSizes)
      .catch(handleError);
  }
};
