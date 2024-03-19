import {Position} from "./position";
import {inlineAddressLoc, Location} from "./location";
import * as L from "leaflet";

export class NamedPosition extends Position {

  constructor(
    latitude: number,
    longitude: number,
    public label: string,
    public address: string,
  ) {
    super(latitude, longitude);
  }

  convertToMaker(): L.Marker
  {
    const lab = new HTMLSpanElement();
    lab.style.fontWeight = 'bold';
    lab.innerText = this.label;

    return  L.marker(this.convertToLatLon(), {
      title: this.label,
      alt: this.label,
    }).bindPopup(lab);
  }

}

export function createNamedPositionFromLocation(loc: Location): NamedPosition
{
  return new NamedPosition(
    loc.latitude,
    loc.longitude,
    loc.label,
    inlineAddressLoc(loc),
    );
}
