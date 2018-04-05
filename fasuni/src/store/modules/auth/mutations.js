export default {
  getToken() {
    return localStorage.getItem('token');
  },
  setToken(context, token) {
    localStorage.setItem('token', token);
  },
  removeToken() {
    localStorage.removeItem('token');
  }
};
