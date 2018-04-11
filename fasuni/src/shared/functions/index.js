export function handleError(error) {
  return error.response;
};

export function getFormatPrice (price) {
  return `${price.toLocaleString()}Đ`;
};

export function reloadApp() {
  window.location.reload();
};
