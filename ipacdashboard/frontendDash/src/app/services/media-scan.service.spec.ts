import { TestBed, inject } from '@angular/core/testing';

import { MediaScanService } from './media-scan.service';

describe('MediaScanService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [MediaScanService]
    });
  });

  it('should be created', inject([MediaScanService], (service: MediaScanService) => {
    expect(service).toBeTruthy();
  }));
});
