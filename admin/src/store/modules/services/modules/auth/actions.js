export default {
  login({ dispatch, rootState }, data) {
    return rootState.http.instance.post(rootState.constants.api.auth.login, data)
      .catch(error => {
        return dispatch('http/handleError', error, { root: true });
      });
  },
  index({ dispatch, rootState }) {
    return rootState.http.instance.get(rootState.constants.api.auth.index)
      .catch(error => {
        return dispatch('http/handleError', error, { root: true });
      });
  }
};
