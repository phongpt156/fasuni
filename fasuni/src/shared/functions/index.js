export function handleError(error) {
  return error.response;
};

export function getFormatPrice(price) {
  if (price) {
    price = price.toString().replace(/\./g, '');
    return `${Number(price).toLocaleString()} VNĐ`;
  }
  return price;
};

export function reloadApp() {
  window.location.reload();
};
