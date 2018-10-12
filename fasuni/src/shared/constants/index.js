export const HOSTNAME = process.env.NODE_ENV === 'production' ? window.location.hostname : 'http://localhost/fasuni/public_html';
export const BASE_URL = `${HOSTNAME}/api`;
export const IMAGE_URL = `${HOSTNAME}/images`;

export const ERROR_MESSAGE = {
  email: {
    required: 'Vui lòng nhập email.',
    type: 'Email bạn nhập không hợp lệ.',
  },
  password: {
    required: 'Vui lòng nhập mật khẩu.',
  },
  phoneNumber: {
    required: 'Vui lòng nhập số điện thoại.',
    format: 'Số điện thoại bạn nhập không hợp lệ.',
  },
  firstName: {
    required: 'Vui lòng nhập tên của bạn',
  },
  lastName: {
    required: 'Vui lòng nhập họ của bạn',
  },
  name: {
    required: 'Vui lòng nhập họ tên của bạn',
  },
  city: {
    required: 'Vui lòng chọn Tỉnh/Thành phố',
  },
  district: {
    required: 'Vui lòng chọn Quận/Huyện',
  },
  address: {
    required: 'Vui lòng nhập địa chỉ',
  },
};

export const GENDER = {
  male: {
    id: 1,
    name: 'Nam',
  },
  female: {
    id: 2,
    name: 'Nữ',
  },
};

export const PATTERN = {
  phoneNumber: /^(01[2689]|09)[0-9]{8}$/,
};
