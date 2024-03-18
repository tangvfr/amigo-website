import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SearchbarEventPageComponent } from './searchbar-event-page.component';

describe('SearchbarEventPageComponent', () => {
  let component: SearchbarEventPageComponent;
  let fixture: ComponentFixture<SearchbarEventPageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SearchbarEventPageComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(SearchbarEventPageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
