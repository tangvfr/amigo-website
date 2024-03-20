import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EventHomePageComponent } from './event-home-page.component';

describe('EventHomePageComponent', () => {
  let component: EventHomePageComponent;
  let fixture: ComponentFixture<EventHomePageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EventHomePageComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(EventHomePageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
