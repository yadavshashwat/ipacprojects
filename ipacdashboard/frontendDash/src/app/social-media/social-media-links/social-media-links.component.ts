/**
 * @author victor
 * component for side links of social media
 */
import { Component, OnInit } from '@angular/core';
// import { MediaPrivilegeService } from "../../services/media-privilege.service";

@Component({
  selector: 'app-social-media-links',
  templateUrl: './social-media-links.component.html',
  styleUrls: ['./social-media-links.component.css']
})
export class SocialMediaLinksComponent implements OnInit {

  // checkMediaPrivilege: boolean;
  // checkMediaWrite: boolean;
  // checkMedia: boolean;
  constructor(
    // private _privilege: MediaPrivilegeService
  ) {
    // this.checkMediaPrivilege = this._privilege.checkMediaPrivilege();
    // this.checkMediaWrite = this._privilege.checkMediaWrite();
    // this.checkMedia = this._privilege.checkMedia();
  }

  ngOnInit() {
  }

}
