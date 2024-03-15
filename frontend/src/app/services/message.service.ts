import {Injectable} from '@angular/core';
import {MatDialog, MatDialogRef} from "@angular/material/dialog";
import {DialogMessageComponent} from "../components/dialog-message/dialog-message.component";

@Injectable({
  providedIn: 'root'
})
export class MessageService {

  private messages: Array<DialogMessage>;
  private dialogRef?: MatDialogRef<DialogMessageComponent, void>;

  constructor(private dialog: MatDialog) {
    this.messages = new Array<DialogMessage>();
  }

  public appendMessage(message: DialogMessage): void
  {
    this.messages.push(message);

    if (this.dialogRef === undefined) {
      this.showNextMessage();
    }
  }

  private showNextMessage(): void
  {
    let msg = this.messages.shift();

    if (msg !== undefined) {
      this.dialogRef = this.dialog.open(DialogMessageComponent, {data: msg});

      this.dialogRef.afterClosed().subscribe(dialog => {
        this.dialogRef = undefined;
        this.showNextMessage();
      });
    }
  }

}

export interface DialogMessage {
  title: string,
  body: string,
}
