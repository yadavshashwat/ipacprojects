import { TestBed, inject } from '@angular/core/testing';

import { MediaPrivilegeService } from './media-privilege.service';

describe('MediaPrivilegeService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [MediaPrivilegeService]
    });
  });

  it('should be created', inject([MediaPrivilegeService], (service: MediaPrivilegeService) => {
    expect(service).toBeTruthy();
  }));
});
