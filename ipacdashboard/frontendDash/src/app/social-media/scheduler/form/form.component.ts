/**
 * @author victor
 * Form for scheduling the post
 */
import {
  Component,
  OnInit,
  Input,
  ChangeDetectorRef,
  AfterViewChecked,
  ViewChild,
  ElementRef
} from '@angular/core';
import {
  FormGroup,
  FormBuilder,
  Validators
} from '@angular/forms';
import { FotoService } from "../../../services/utilities/upload/foto.service";
import { SchedulerService } from "../../../services/social-media/scheduler.service";
import { forkJoin } from 'rxjs';
export interface Url {
  url: string;
}
export interface UploadFotosResponse {
  status: string;
  msg: string;
  counter: number;
  result: Array<Url>;
}

@Component({
  selector: 'app-form',
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.css']
})
export class FormComponent implements OnInit, AfterViewChecked {

  minDate = new Date();
  scheduleForm: FormGroup;
  uploaded: Array<Url> = [];
  filesToUpload: File | FileList = null;
  showCorrectTime = false;
  selectedTime: any;
  fileDisable = false;

  @ViewChild('inputEl') public inputEl: ElementRef;


  private _form;
  private _selected;

  @Input()
  set form(value: boolean) {
    this._form = value;
  }
  get form(): boolean {
    return this._form;
  }

  @Input()
  set selected(value: any) {
    this._selected = value;
  }
  get selected(): any {
    return this._selected;
  }

  constructor(
    public fb: FormBuilder,
    private _foto: FotoService,
    private cdr: ChangeDetectorRef,
    private _scheduler: SchedulerService
  ) {
    this.buildScheduleForm();
  }

  ngAfterViewChecked() {
    this.cdr.detectChanges();
  }

  /**
   * Construction of add news form
   */
  public buildScheduleForm() {
    this.scheduleForm = this.fb.group({
      'text': ['', [
        Validators.required
      ]],
      'link': ['', []],
      'date': ['', [
        Validators.required
      ]],
      'time': ['', [
        Validators.required
      ]]
    });

    this.scheduleForm.valueChanges
      .subscribe(data => this.onScheduleFormValueChanged(data));
    this.onScheduleFormValueChanged(); // (re)set validation messages now
  }

  /**
   * When Form Value changes
   * @param data any
   */
  onScheduleFormValueChanged(data?: any) {
    if (!this.scheduleForm) { return; }
    const form = this.scheduleForm;
    for (const field in this.scheduleFormErrors) {
      // clear previous error message (if any)
      this.scheduleFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.scheduleValidationMessages[field];
        for (const key in control.errors) {
          this.scheduleFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  /**
   * add news form errors
   */
  scheduleFormErrors = {
    'text': '',
    'link': '',
    'date': '',
    'time': ''
  };

  /**
   * Validation messages for the input fields
   */
  scheduleValidationMessages = {
    'text': {
      'required': 'text is required.'
    },
    'link': {},
    'date': {
      'required': 'Date is required.'
    },
    'time': {
      'required': 'Time is required.'
    }
  };

  ngOnInit() {
  }
  fileSelectMultipleMsg: any = ['No file(s) selected yet.'];

  selectMultipleEvent(files: FileList | File): void {
    if (files instanceof FileList) {
      const names: string[] = [];
      for (let i = 0; i < files.length; i++) {
        names.push(files[i].name);
      }
      this.fileSelectMultipleMsg = names.join('\n');
    } else {
      this.fileSelectMultipleMsg = files.name;
    }
  }

  uploadMultipleEvent(files: FileList | File): void {
    this._foto.uploadToServerImage(files).subscribe((data: UploadFotosResponse) => {
      this.uploaded = data.result;
      if (this.uploaded.length > 0) {
        // disable the link field
        this.inputEl.nativeElement.disabled = true;
      } else {
        this.inputEl.nativeElement.disabled = false;
      }
    });
  }

  cancelMultipleEvent(): void {
    this.fileSelectMultipleMsg = 'No file(s) selected yet.';
  }

  onScheduleSubmit() {
    if (this.checkDateTime()) {
      // API call
      this.showCorrectTime = false;
      // Math.round(new Date("2013/09/05 15:34:00").getTime()/1000) UNIX TIME STAMP

      const imageArr = this.uploaded.map((foto) => {
        return foto.url;
      });

      const hours = this.selectedTime.getHours();
      const minutes = this.selectedTime.getMinutes();
      const year = this.selectedTime.getFullYear();
      const month = this.selectedTime.getMonth() < 10 ? "0" + this.selectedTime.getMonth() : this.selectedTime.getMonth();
      const day = this.selectedTime.getDay() < 10 ? "0" + this.selectedTime.getDay() : this.selectedTime.getDay();

      const APICALLS = [];
      this.selected.forEach(record => {
        const requestPayload = {
          message: this.scheduleForm.value.text,
          page_id: record.page_id,
          link: [this.scheduleForm.value.link],
          images: imageArr,
          timestamp: Math.round(new Date("${year}/${month}/${day} ${hours}:${minutes}:00").getTime() / 1000)
        };
        const API = this._scheduler.schedule(requestPayload);
        APICALLS.push(API);
      });

      forkJoin(APICALLS).subscribe((results) => {
        console.log(results);
        alert('Done ! Post are scheduled !');
        this.fileDisable = false;
        this.inputEl.nativeElement.disabled = false;
      });
    } else {
      // msg
      this.showCorrectTime = true;
    }
  }

  checkDateTime() {
    // get the date
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();
    const currentDay = currentDate.getDay();

    const selectedDate = this.scheduleForm.value.date;
    const selectedYear = selectedDate.getFullYear();
    const selectedMonth = selectedDate.getMonth();
    const selectedDay = selectedDate.getDay();

    if (currentYear === selectedYear && currentMonth === selectedMonth && currentDay === selectedDay) {
      return this.checkTime();
    } else {
      return true;
    }
  }

  checkTime() {
    const time = this.scheduleForm.value.time;
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

