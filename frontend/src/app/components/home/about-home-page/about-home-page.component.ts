import { Component } from '@angular/core';
import {RouterLink} from "@angular/router";

@Component({
  selector: 'app-about-home-page',
  standalone: true,
  imports: [
    RouterLink
  ],
  templateUrl: './about-home-page.component.html',
  styleUrl: './about-home-page.component.css'
})
export class AboutHomePageComponent {

}
