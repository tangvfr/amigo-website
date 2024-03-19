export interface Location {
  label: string;
  latitude: number;
  longitude: number;
  country?: string;
  city?: string;
  postalCode?: string;
  adresse?: string;
}

export function inlineAddressLoc(loc: Location) {
  return (loc.adresse !== undefined ? loc.adresse + ', ' : '')
    + (loc.country ?? '')
    + ' ' + (loc.city ?? '')
    + ' ' + (loc.country ?? '')
  ;
}
