import httpClient from './../http';
import { handleError } from './../functions';
import { CITY } from './../constants/api';

export default {
  getAll() {
    console.log(city.getAll);
    return httpClient.get(CITY.getAll)
      .catch(handleError);
  }
};
