export function handleError(error) {
  return error.response;
};

export function getFormatPrice (price) {
  return `${price.toLocaleString()}Đ`;
};
