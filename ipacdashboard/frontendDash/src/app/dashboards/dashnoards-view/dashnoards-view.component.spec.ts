import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DashnoardsViewComponent } from './dashnoards-view.component';

describe('DashnoardsViewComponent', () => {
  let component: DashnoardsViewComponent;
  let fixture: ComponentFixture<DashnoardsViewComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DashnoardsViewComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DashnoardsViewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
