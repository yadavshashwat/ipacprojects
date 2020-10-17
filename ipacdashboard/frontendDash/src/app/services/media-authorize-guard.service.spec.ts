import { TestBed, inject } from '@angular/core/testing';

import { MediaAuthorizeGuardService } from './media-authorize-guard.service';

describe('MediaAuthorizeGuardService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [MediaAuthorizeGuardService]
    });
  });

  it('should be created', inject([MediaAuthorizeGuardService], (service: MediaAuthorizeGuardService) => {
    expect(service).toBeTruthy();
  }));
});
