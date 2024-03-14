import {components} from "../schema.api";

export interface Student {
  id: number;
  name: string;
  lastName: string;
  img?: string;
  level: components["schemas"]["Student.jsonld-office"]["level"];
}
