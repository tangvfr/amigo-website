import {Position} from "./position";

export class NamedPosition extends Position {

  constructor(
    latitude: number,
    longitude: number,
    public label: string,
    public address: string,
  ) {
    super(latitude, longitude);
  }

}
