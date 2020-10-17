/**
 * @author victor
 * Parent component for the scheduler
 */
import {
  Component,
  OnInit,
  DoCheck,
  ChangeDetectorRef,
  ViewChild,
  ElementRef
} from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { FotoService } from "../../services/utilities/upload/foto.service";
import { SchedulerService } from "../../services/social-media/scheduler.service";
import { Url } from "../interfaces/url";
import { UploadFotosResponse } from "../interfaces/upload-fotos-response";
import { forkJoin } from 'rxjs';
import { MatSnackBar } from '@angular/material';
import { PageDigitalMedia } from "../scheduler/records/records.component";
import { Router } from "@angular/router";

export interface PostType {
  post_type: string;
}

@Component({
  selector: 'app-scheduler',
  templateUrl: './scheduler.component.html',
  styleUrls: ['./scheduler.component.css']
})
export class SchedulerComponent implements OnInit, DoCheck {

  isLinear = true;
  postFormGroup: FormGroup;
  textFormGroup: FormGroup;
  imageFormGroup: FormGroup;
  linkFormGroup: FormGroup;
  videoFormGroup: FormGroup;
  scheduleFormGroup: FormGroup;
  uploadedImage: Array<Url>;
  uploadedVideo: Array<Url>;
  progress = false;
  finalForm = false;
  selectionCompleted = false;
  selectionItems = [];
  post_types: any[] = [
    { value: 'link', viewValue: 'Link' },
    { value: 'image', viewValue: 'Image' },
    { value: 'text', viewValue: 'Text' },
    { value: 'video', viewValue: 'Video' }
  ];

  textForm = false;
  linkForm = false;
  imageForm = false;
  videoForm = false;
  minDate = new Date();
  showCorrectTime = false;
  selectedTime: any;

  selectedRecord: any;
  selectedRecords: any = [];
  search: string;
  state: string;
  district: string;
  clear: any;
  clearCriteria: any;
  selected = [];

  // Stepper code

  showParticularForm(value: PostType) {
    if (!value.post_type) {
      return;
    }
    switch (value.post_type) {
      case 'text':
        this.textForm = true;
        this.linkForm = false;
        this.imageForm = false;
        this.videoForm = false;
        break;
      case 'link':
        this.linkForm = true;
        this.textForm = false;
        this.imageForm = false;
        this.videoForm = false;
        break;
      case 'image':
        this.imageForm = true;
        this.textForm = false;
        this.linkForm = false;
        this.videoForm = false;
        break;
      case 'video':
        this.imageForm = false;
        this.textForm = false;
        this.linkForm = false;
        this.videoForm = true;
        break;
      default:
        break;
    }
  }

  chosePostType(event) {
    this.showParticularForm(this.postFormGroup.value);
  }

  pageSelected(emission: { value: boolean, data: Array<PageDigitalMedia> }) {
    this.selectionCompleted = emission.value;
    this.selectionItems = emission.data;
  }

  fileSelectMultipleMsgImage: any = ['No file(s) selected yet.'];
  fileSelectMultipleMsgVideo: any = ['No file(s) selected yet.'];

  selectMultipleEventImage(files: FileList | File): void {
    if (files instanceof FileList) {
      const names: string[] = [];
      for (let i = 0; i < files.length; i++) {
        names.push(files[i].name);
      }
      this.fileSelectMultipleMsgImage = names.join('\n');
    } else {
      this.fileSelectMultipleMsgImage = files.name;
    }
  }

  uploadMultipleEventImage(files: FileList | File): void {
    this.progress = true;
    this._foto.uploadToServerImage(files).subscribe((data: UploadFotosResponse) => {
      this.uploadedImage = data.results;
      this.progress = false;
    });
  }

  cancelMultipleEventImage(): void {
    this.fileSelectMultipleMsgImage = 'No file(s) selected yet.';
  }

  selectMultipleEventVideo(files: FileList | File): void {
    if (files instanceof FileList) {
      const names: string[] = [];
      for (let i = 0; i < files.length; i++) {
        names.push(files[i].name);
      }
      this.fileSelectMultipleMsgVideo = names.join('\n');
    } else {
      this.fileSelectMultipleMsgVideo = files.name;
    }
  }

  uploadMultipleEventVideo(files: FileList | File): void {
    this.progress = true;
    this._foto.uploadToServerVideo(files).subscribe((data: UploadFotosResponse) => {
      this.uploadedVideo = data.results;
      this.progress = false;
    });
  }

  cancelMultipleEventVideo(): void {
    this.fileSelectMultipleMsgVideo = 'No file(s) selected yet.';
  }




  constructor(
    private store: Store<fromStore.State>,
    private cdr: ChangeDetectorRef,
    private _formBuilder: FormBuilder,
    private _foto: FotoService,
    private _scheduler: SchedulerService,
    public snackBar: MatSnackBar,
    public _router: Router
  ) { }

  ngOnInit() {
    this.postFormGroup = this._formBuilder.group({
      post_type: ['', Validators.required]
    });

    this.textFormGroup = this._formBuilder.group({
      message: ['', Validators.required]
    });

    this.imageFormGroup = this._formBuilder.group({
      message: ['', []],
    });

    this.videoFormGroup = this._formBuilder.group({
      message: ['', []],
    });

    this.linkFormGroup = this._formBuilder.group({
      message: ['', []],
      link: ['', Validators.required]
    });

    this.scheduleFormGroup = this._formBuilder.group({
      date: ['', Validators.required],
      time: ['', Validators.required]
    });
  }

  ngDoCheck() {
    this.cdr.detectChanges();
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

  onScheduleSubmit() {
    this.finalForm = true;
    if (this.checkDateTime()) {
      // API call
      this.showCorrectTime = false;

      const hours = this.selectedTime.getHours();
      const minutes = this.selectedTime.getMinutes() < 10 ? "0" + this.selectedTime.getMinutes() : this.selectedTime.getMinutes();
      const selectedDate = this.scheduleFormGroup.value.date;
      const year = selectedDate.getFullYear().toString().substr(-2);
      const month = selectedDate.getMonth() < 10 ? "0" + selectedDate.getMonth() + 1 : selectedDate.getMonth() + 1;
      const day = selectedDate.getDate() < 10 ? "0" + selectedDate.getDate() : selectedDate.getDate();

      const APICALLS = [];

      const timestamp = Object.assign({}, { timestamp: `${day}-${month}-${year}-${hours}-${minutes}-00` });
      const page_id = Object.assign({}, { page_ids: this.selectionItems.map(record => record.page_id).join(',') });
      const same = Object.assign({}, this.postFormGroup.value, timestamp, page_id);
      let requestPayload = {};

      switch (this.postFormGroup.value.post_type) {
        case 'text':
          requestPayload = Object.assign(same, this.textFormGroup.value);
          break;
        case 'image':
          const imageArr = this.uploadedImage.map((foto) => {
            return foto.url;
          });
          const finalImageArr = imageArr.join(',');
          requestPayload = Object.assign(same, { images: finalImageArr }, this.imageFormGroup.value);
          break;
        case 'video':
          const videoArr = this.uploadedVideo.map((video) => {
            return video.url;
          });
          const finalVideoArr = videoArr.join(',');
          requestPayload = Object.assign(same, { video: finalVideoArr }, this.videoFormGroup.value);
          break;
        case 'link':
          requestPayload = Object.assign(same, this.linkFormGroup.value);
          break;
        default:
          break;
      }
      const API = this._scheduler.schedule(requestPayload).subscribe(
        (results) => {
          console.log(results);
          this.finalForm = false;
          // alert('Done ! Post are scheduled !');
          // this.snackBar.open('Done! Post(s) scheduled', 'Close', {
          //   duration: 2000,
          // });
          this._router.navigate(['dashboards/social-media/scheduled-posts']);
        },
        (error) => {
          console.log(error);
        }
      );
    } else {
      // msg
      this.showCorrectTime = true;
      this.finalForm = false;
    }
  }

  checkDateTime() {
    // get the date
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();
    const currentDay = currentDate.getDate();

    const selectedDate = this.scheduleFormGroup.value.date;
    const selectedYear = selectedDate.getFullYear();
    const selectedMonth = selectedDate.getMonth();
    const selectedDay = selectedDate.getDate();

    if (currentYear === selectedYear && currentMonth === selectedMonth && currentDay === selectedDay) {
      return this.checkTime();
    } else {
      const time = this.scheduleFormGroup.value.time;
      this.selectedTime = this.getTime(time);
      return true;
    }
  }

  checkTime() {
    const time = this.scheduleFormGroup.value.time;
    const currentTime = new Date();

    const currentHours = currentTime.getHours();
    const currentMinutes = currentTime.getMinutes();

    const date = new Date();
    let hours: any = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
    const am_pm = date.getHours() >= 12 ? "pm" : "am";
    hours = hours < 10 ? "0" + hours : hours;
    const minutes: any = this.add_minutes(date, 11);
    const finalminutes = minutes.getMinutes() < 10 ? "0" + minutes.getMinutes() : minutes.getMinutes();

    const minCheckTime = this.getTime(`${hours}:${finalminutes} ${am_pm}`);
    this.selectedTime = this.getTime(time);

    if (this.selectedTime > minCheckTime) {
      return true;
    } else {
      return false;
    }

  }

  add_minutes = (dt, minutes) => {
    return new Date(dt.getTime() + minutes * 60000);
  }

  getTime(time) {
    const startTime = new Date();
    const parts = time.match(/(\d+):(\d+) (am|pm)/);
    if (parts) {
      let hours = Number(parts[1]);
      const minutes = Number(parts[2]);
      const tt = parts[3];
      if (tt === 'pm' && hours < 12) {
        hours += 12;
      }
      startTime.setHours(hours, minutes, 0, 0);
    }
    return startTime;
  }

}
