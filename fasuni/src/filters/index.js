import { getFormatPrice } from '@/shared/functions';

export function priceFormat(price) {
  const formattedPrice = getFormatPrice(price);

  return formattedPrice;
};
