import {Component, Input} from '@angular/core';
import {NgIf} from "@angular/common";

@Component({
  selector: 'app-poster',
  standalone: true,
  imports: [
    NgIf
  ],
  templateUrl: './poster.component.html',
})
export class PosterComponent {

  @Input() test: string | undefined;

}
