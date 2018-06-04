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
  },
  getLookbooksOfMonth(gender, year, month) {
    return httpClient.get(`${LOOKBOOK.getLookbooksOfMonth}${gender}/${year}/${month}`)
      .catch(handleError);
  }
};
