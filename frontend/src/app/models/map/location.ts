import * as L from "leaflet";

export interface Location {
  latitude: number,
  longitude: number,
}

export function convertLocationToLatLon(location: Location): L.LatLng
{
  return L.latLng(location.latitude, location.longitude);
}

export function convertLocationsToLatLons(locations: Location[]): L.LatLng[]
{
  let locs = [];
  for (let loc of locations) {
    locs.push(convertLocationToLatLon(loc));
  }
  return locs;
}
