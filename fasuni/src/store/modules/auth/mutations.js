export default {
  setToken(state, token) {
    localStorage.setItem('token', token);
  },
  getToken() {
    localStorage.getItem('token');
  },
  removeToken() {
    localStorage.removeItem('token');
  },
};
