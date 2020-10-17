import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MediaScanComponent } from './media-scan.component';

describe('MediaScanComponent', () => {
  let component: MediaScanComponent;
  let fixture: ComponentFixture<MediaScanComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MediaScanComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MediaScanComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
