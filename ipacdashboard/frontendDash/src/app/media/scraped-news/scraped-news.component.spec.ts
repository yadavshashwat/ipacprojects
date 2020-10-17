import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ScrapedNewsComponent } from './scraped-news.component';

describe('ScrapedNewsComponent', () => {
  let component: ScrapedNewsComponent;
  let fixture: ComponentFixture<ScrapedNewsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ScrapedNewsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ScrapedNewsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
