import { GENDER } from '@/shared/constants';

export function formatGender(gender) {
  if (GENDER.male.id === gender) {
    return GENDER.male.name;
  } else if (GENDER.female.id === gender) {
    return GENDER.female.name;
  }
};

export function encodeURI(uri) {
  return window.encodeURI(uri);
};
