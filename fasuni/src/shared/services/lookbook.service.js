import httpClient from './../http';
import { handleError } from './../functions';
import { LOOKBOOK } from './../constants/api';

export default {
  getMaleMonthListSnapshot() {
    return httpClient.get(LOOKBOOK.getMaleMonthListSnapshot)
      .catch(handleError);
  },
  getFemaleMonthListSnapshot() {
    return httpClient.get(LOOKBOOK.getFemaleMonthListSnapshot)
      .catch(handleError);
  }
};
