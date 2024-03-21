import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AboutAmigoPageComponent } from './about-amigo-page.component';

describe('AboutAmigoPageComponent', () => {
  let component: AboutAmigoPageComponent;
  let fixture: ComponentFixture<AboutAmigoPageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AboutAmigoPageComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(AboutAmigoPageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
