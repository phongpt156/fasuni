export function handleError(error) {
  return error.response;
};

export function getFormatPrice (price) {
  if (price) {
    return `${price.toLocaleString()}Đ`;
  }
  return price;
};

export function reloadApp() {
  window.location.reload();
};
