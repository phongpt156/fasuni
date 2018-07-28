export const BASE_URL = process.env.NODE_ENV === 'production' ? location.origin + '/api/admin' : 'http://fasuni.localhost/api/admin';
export const IMAGE_URL = process.env.NODE_ENV === 'production' ? location.origin + '/images' : 'http://fasuni.localhost/images';
export const COLLECTION_IMAGE_URL = process.env.NODE_ENV === 'production' ? location.origin + '/images/collections' : 'http://fasuni.localhost/images/collections';
export const LOOKBOOK_IMAGE_URL = process.env.NODE_ENV === 'production' ? location.origin + '/images/lookbooks' : 'http://fasuni.localhost/images/lookbooks';

export const ERROR_MESSAGE = {
  email: {
    required: 'Please fill in your email.',
    type: 'Please fill in your correct email.'
  },
  password: {
    required: 'Please fill in your password.'
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
  },
  lookbook: {
    name: {
      required: 'Vui lòng nhập tên lookbook'
    }
  },
  collection: {
    name: {
      required: 'Vui lòng nhập tên bộ sưu tập'
    }
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
