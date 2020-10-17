import { SocialMediaModule } from './social-media.module';

describe('SocialMediaModule', () => {
  let socialMediaModule: SocialMediaModule;

  beforeEach(() => {
    socialMediaModule = new SocialMediaModule();
  });

  it('should create an instance', () => {
    expect(socialMediaModule).toBeTruthy();
  });
});
