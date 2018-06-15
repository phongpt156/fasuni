export function handleError(error) {
  return error.response;
};

export function reloadApp() {
  window.location.reload();
};

export function getFormatPrice(price) {
  if (price) {
    price = Number(price).toString().replace(/\./g, '');
    return `${Number(price).toLocaleString()} VNĐ`;
  }
  return price;
};
