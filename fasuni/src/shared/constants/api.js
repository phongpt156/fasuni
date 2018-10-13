export const AUTH = {
  index: '/auth',
  login: '/auth/login',
  logout: '/auth/logout',
  register: '/auth/register',
};

export const CITY = {
  getAll: '/city',
  getDistricts: '/city/district/',
};

export const DISTRICT = {
  getWards: '/district/ward/',
};

export const FACEBOOK = {
  login: '/auth/facebook/login',
};

export const GOOGLE = {
  login: '/auth/google/login',
};

export const CATEGORY = {
  getAll: '/category',
  getHierachyCategory: '/category/hierachy/',
};

export const PRODUCT = {
  getAll: '/product',
  getOne: '/product/',
  getByCategory: '/product/category/',
  getRelevant: '/product/relevant/',
  searchByName: '/product/search/',
};

export const USER_PRODUCT_COMMUNICATION = {
  like: '/like-product/',
  dislike: '/dislike-product/',
};

export const LOOKBOOK = {
  getMaleMonthListSnapshot: '/lookbook/get-male-month-list-snapshot',
  getFemaleMonthListSnapshot: '/lookbook/get-female-month-list-snapshot',
  getLookbooksOfMonth: '/lookbook/get-lookbooks-of-month/',
};

export const ATTRIBUTE_VALUE = {
  getColors: '/attribute-value/color',
  getSizes: '/attribute-value/size',
};

export const COLLECTION = {
  getAll: '/collection',
  getOne: '/collection/',
};

export const USER = {
  getWhistlist: '/user/whistlist',
  getDeliveryInfo: '/user/delivery-info',
};

export const ORDER = {
  store: '/order',
  getOne: '/order/',
  getOrderHistoriesOfUser: '/order/user-history',
  delete: '/order/',
};

export const USER_DELIVERY_INFO = {
  getInfoOfUser: '/user-delivery-info/user',
  store: '/user-delivery-info',
};
