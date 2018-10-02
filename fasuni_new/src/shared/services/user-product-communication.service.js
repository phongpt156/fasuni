import httpClient from './../http';
import { handleError } from './../functions';
import { USER_PRODUCT_COMMUNICATION } from './../constants/api';

export default {
  like(productId) {
    return httpClient.get(`${USER_PRODUCT_COMMUNICATION.like}${productId}`)
      .catch(handleError);
  },
  dislike(productId) {
    return httpClient.get(`${USER_PRODUCT_COMMUNICATION.dislike}${productId}`)
      .catch(handleError);
  }
};
