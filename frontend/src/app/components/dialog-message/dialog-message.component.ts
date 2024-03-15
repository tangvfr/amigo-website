import {Component, Inject} from '@angular/core';
import {
  MAT_DIALOG_DATA,
  MatDialogActions,
  MatDialogClose,
  MatDialogContent,
  MatDialogTitle
} from "@angular/material/dialog";
import {MatButton} from "@angular/material/button";
import {DialogMessage} from "../../services/message.service";

@Component({
  selector: 'app-dialog-message',
  standalone: true,
  imports: [
    MatDialogTitle,
    MatDialogContent,
    MatDialogActions,
    MatButton,
    MatDialogClose
  ],
  templateUrl: './dialog-message.component.html',
  styleUrl: './dialog-message.component.css'
})
export class DialogMessageComponent {
  constructor(@Inject(MAT_DIALOG_DATA) public data: DialogMessage) {}
}
