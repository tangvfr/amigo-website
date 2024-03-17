import {Component} from '@angular/core';
import {RouterLink} from "@angular/router";
import {NgForOf} from "@angular/common";
import {PosterComponent} from "../poster/poster.component";
import {MatButton, MatFabAnchor} from "@angular/material/button";
import {MatIcon} from "@angular/material/icon";
import {MessageService} from "../../services/message.service";
import { NgOptimizedImage } from '@angular/common'

@Component({
  selector: 'app-testh',
  standalone: true,
  imports: [RouterLink, NgForOf, PosterComponent, MatIcon, MatFabAnchor, MatButton, NgOptimizedImage],
  templateUrl: './testh.component.html',
  styleUrl: './testh.component.css'
})
export class TesthComponent {

  testList: Array<string> = ['salut', 'bg', 'tu es super beau'];

  constructor(
    private readonly messageService: MessageService
  ) {}

  openTestDialog(): void
  {
    //message qui sont en dialog message
    this.messageService.appendMessage({
      title: 'a ttile',
      body: 'corp 1'
    });
    this.messageService.appendMessage({
      title: 'to ttile',
      body: 'corp 2'
    });
    this.messageService.appendMessage({
      title: '3 ttile',
      body: 'corp 3'
    });
  }

}
