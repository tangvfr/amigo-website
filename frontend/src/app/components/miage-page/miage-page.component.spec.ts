import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MiagePageComponent } from './miage-page.component';

describe('MiagePageComponent', () => {
  let component: MiagePageComponent;
  let fixture: ComponentFixture<MiagePageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MiagePageComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(MiagePageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
