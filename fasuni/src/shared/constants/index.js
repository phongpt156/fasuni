export const BASE_URL = 'http://localhost:8000/api';

export const ERROR_MESSAGE = {
  email: {
    required: 'Vui lòng nhập email.',
    type: 'Email bạn nhập không hợp lệ.'
  },
  password: {
    required: 'Vui lòng nhập mật khẩu.'
  },
  phoneNumber: {
    required: 'Vui lòng nhập số điện thoại.',
    format: 'Số điện thoại bạn nhập không hợp lệ.'
  }
};

export const GENDER = {
  male: {
    id: 1,
    name: 'Nam'
  },
  female: {
    id: 2,
    name: 'Nữ'
  }
};

export const PATTERN = {
  phoneNumber: /^(01[2689]|09)[0-9]{8}$/
};
