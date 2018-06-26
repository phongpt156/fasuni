import { getFormatPrice } from '@/shared/functions';

export function priceFormat(price) {
  const formattedPrice = getFormatPrice(price);

  return formattedPrice;
};

export function encodeURI(uri) {
  return window.encodeURI(uri);
};

export function dateFormat(date) {
  date = new Date(date);

  if (!date || date.toString() === 'Invalid Date') {
    return date;
  }

  let minutes = date.getMinutes();
  let hours = date.getHours();
  let day = date.getDate();
  let month = date.getMonth() + 1;
  let year = date.getFullYear();

  minutes = minutes < 10 ? `0${minutes}` : minutes;
  hours = hours < 10 ? `0${hours}` : hours;
  day = day < 10 ? `0${day}` : day;
  month = month < 10 ? `0${month}` : month;

  return `${hours}:${minutes} ${day}/${month}/${year}`;
}

export function getLocalDatefromUtcDate(utcDate) {
  const date = new Date(utcDate);

  if (!date || date.toString() === 'Invalid Date') {
    return date;
  }

  const offset = date.getTimezoneOffset();
  date.setHours(date.getHours() - (offset / 60));

  const localDate = dateFormat(date);

  return localDate;
}
