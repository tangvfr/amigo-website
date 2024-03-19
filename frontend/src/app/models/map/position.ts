import * as L from "leaflet";

export class Position {

  constructor(
    public latitude: number,
    public longitude: number,
  ) {};

  convertToLatLon(): L.LatLng
  {
    return L.latLng(this.latitude, this.longitude);
  }

}

export function convertPositionsToLatLons(positions: Position[]): L.LatLng[]
{
  let poss = [];
  for (let pos of positions) {
    poss.push(pos.convertToLatLon());
  }
  return poss;
}
