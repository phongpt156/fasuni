const config = {
  baseUrl: 'http://localhost:8000/api/admin'
};
const errorMessage = {
  email: {
    required: 'Please fill in your email.',
    type: 'Please fill in your correct email.'
  },
  password: {
    required: 'Please fill in your password.'
  }
};
const api = {
  auth: {
    login: config.baseUrl + '/auth/login',
    index: config.baseUrl + '/auth'
  }
};

const state = {
  config,
  errorMessage,
  api
};

export default {
  namespaced: true,
  state
};
