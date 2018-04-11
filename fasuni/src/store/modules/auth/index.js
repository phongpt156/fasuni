const mutations = {
  setToken(state, token) {
    localStorage.setItem('token', token);
  },
  getToken(state) {
    localStorage.getItem('token');
  },
  removeToken() {
    localStorage.removeItem('token');
  }
};

export default {
  namespaced: true,
  mutations
};
