export const BASE_URL = process.env.NODE_ENV === 'production' ? 'api' : 'https://localhost/fasuni/backend/public/api';
export const IMAGE_URL = process.env.NODE_ENV === 'production' ? 'images' : 'https://localhost/fasuni/backend/public/images';
// export const BASE_URL = 'https://8bed004b.ngrok.io/api';

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
  },
  firstName: {
    required: 'Vui lòng nhập tên của bạn'
  },
  lastName: {
    required: 'Vui lòng nhập họ của bạn'
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
