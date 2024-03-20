import {Injectable} from '@angular/core';
import {MatDialog, MatDialogRef} from "@angular/material/dialog";
import {DialogMessageComponent} from "../components/dialog-message/dialog-message.component";
import {Location} from "../models/map/location";
import {AddresseMapDialogComponent} from "../components/addresse-map-dialog/addresse-map-dialog.component";

@Injectable({
  providedIn: 'root'
})
export class MapService {
  constructor(private dialog: MatDialog) {}

  showMap(
    title: string,
    locations: Location[]
  ) {
    this.dialog.open(AddresseMapDialogComponent, {data: {
        locations: locations,
        title: title,
      }});
  }

}
