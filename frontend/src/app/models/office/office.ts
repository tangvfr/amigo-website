import {Hub} from "./hub";
import {HydraList} from "../hydra-list";
import {components} from "../schema.api";
import {Student} from "./student";
import {Role} from "./role";

export class Office {

  private hubs: Map<number, Hub>;

  constructor(office: HydraList<components["schemas"]["Mandate.jsonld-office"]>) {
    this.hubs = new Map();

    //convertion du bureau
    for (let mandate of office["hydra:member"]) {
      let student = this.convertStudent(mandate.student);

      for (let aRole of mandate.roles!) {
        let role = this.convertRole(aRole);
        let hub = this.getHub(aRole.hub);
        hub.composition.add({role, student});
      }
    }
  }

  public getHubs(): IterableIterator<Hub>
  {
    return this.hubs.values();
  }

  private getHub(aHub: components["schemas"]["Hub.jsonld-office"]): Hub
  {
    let hub = this.hubs.get(aHub.id);

    //si non défini on le défini
    if (hub === undefined) {
      hub = this.convertHub(aHub)
      this.hubs.set(hub.id, hub);
    }

    return hub;
  }

  private convertHub(hub: components["schemas"]["Hub.jsonld-office"]): Hub
  {
    return {
      id: hub.id,
      name: hub.name,
      description: hub.description,
      composition: new Set(),
    };
  }

  private convertRole(role: components["schemas"]["Role.jsonld-office"]): Role
  {
    return {
      id: role.id,
      name: role.name,
    };
  }

  private convertStudent(student: components["schemas"]["Student.jsonld-office"]): Student
  {
    return {
      id: student.id,
      name: student.name,
      lastName: student.lastName,
      img: student.img !== null ? student.img : undefined,
      level: student.level,
    };
  }

}
