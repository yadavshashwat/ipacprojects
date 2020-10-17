import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FacebookPageOverviewComponent } from './facebook-page-overview.component';

describe('FacebookPageOverviewComponent', () => {
  let component: FacebookPageOverviewComponent;
  let fixture: ComponentFixture<FacebookPageOverviewComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FacebookPageOverviewComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FacebookPageOverviewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
