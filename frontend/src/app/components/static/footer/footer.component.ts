import { Component } from '@angular/core';
import {NgOptimizedImage} from "@angular/common";
import {environment} from "../../../../environments/environment";

@Component({
  selector: 'app-footer',
  standalone: true,
  imports: [
    NgOptimizedImage
  ],
  templateUrl: './footer.component.html',
  styleUrl: './footer.component.css'
})
export class FooterComponent {

  protected readonly environment = environment;
}
