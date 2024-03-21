import {Component, Input} from '@angular/core';
import {Post} from "../../../models/office/post";
import {environment} from "../../../../environments/environment";

@Component({
  selector: 'app-office-card',
  standalone: true,
  templateUrl: './office-card.component.html',
  styleUrl: './office-card.component.css'
})
export class OfficeCardComponent {

  @Input({required: true}) public member!: Post

  protected readonly environment = environment;

}
