import {Component, Input} from '@angular/core';
import {Post} from "../../../models/office/post";

@Component({
  selector: 'app-office-card',
  standalone: true,
  imports: [],
  templateUrl: './office-card.component.html',
  styleUrl: './office-card.component.css'
})
export class OfficeCardComponent {

  @Input() member: Post | undefined;

}
