import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DistrictMappingComponent } from './district-mapping.component';

describe('DistrictMappingComponent', () => {
  let component: DistrictMappingComponent;
  let fixture: ComponentFixture<DistrictMappingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DistrictMappingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DistrictMappingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
