/**
 * @author victor
 * Side links component
 */
import { Component, OnInit } from '@angular/core';
import { MediaPrivilegeService } from "../../services/media-privilege.service";

@Component({
  selector: 'app-media-links',
  templateUrl: './media-links.component.html',
  styleUrls: ['./media-links.component.css']
})
export class MediaLinksComponent implements OnInit {
  checkMediaPrivilege: boolean;
  checkMediaWrite: boolean;
  checkMedia: boolean;
  constructor(
    private _privilege: MediaPrivilegeService
  ) {
    this.checkMediaPrivilege = this._privilege.checkMediaPrivilege();
    this.checkMediaWrite = this._privilege.checkMediaWrite();
    this.checkMedia = this._privilege.checkMedia();
  }

  ngOnInit() {
  }

}
