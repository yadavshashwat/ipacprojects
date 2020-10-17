import { Component, OnInit, Inject } from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";
import { SchedulerService } from "../../services/social-media/scheduler.service";
import { FormControl } from '@angular/forms';
import { MatSnackBar } from '@angular/material';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

export interface ScheduledPostsPayload {
  job_type?: string;
  job_status: string;
  start_date?: string;
  end_date?: string;
}

@Component({
  selector: 'app-scheduled-posts',
  templateUrl: './scheduled-posts.component.html',
  styleUrls: ['./scheduled-posts.component.css']
})
export class ScheduledPostsComponent implements OnInit {

  payload: ScheduledPostsPayload;
  data: any;

  statusFilter = new FormControl();
  typeFilter = new FormControl();
  startDateFilter = new FormControl();
  endDateFilter = new FormControl();

  deleteProgress = false;

  types = [
    { value: 'text', viewValue: 'Text' },
    { value: 'link', viewValue: 'Link' },
    { value: 'image', viewValue: 'Image' }
  ];

  statuses = ['Pending', 'Scheduled', 'Failed', 'Deleted'];

  constructor(
    private store: Store<fromStore.State>,
    private _scheduler: SchedulerService,
    public snackBar: MatSnackBar,
    public dialog: MatDialog
  ) {
    this.payload = <ScheduledPostsPayload>{};
  }

  ngOnInit() {
    this.fetchRecords();
  }

  resetData() {
    this.payload = <ScheduledPostsPayload>{};
    this.typeFilter.patchValue(null);
    this.statusFilter.patchValue(null);
    this.startDateFilter.patchValue(null);
    this.endDateFilter.patchValue(null);
    this.fetchRecords();
  }

  fetchRecords() {
    this._scheduler.scheduledPosts(this.payload).subscribe(
      (success) => {
        console.log(success);
        this.data = success;
      },
      (error) => {
        console.log(error);
      }
    );
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

  filterData() {

    const startDateFilter = this.startDateFilter.value;
    const endDateFilter = this.endDateFilter.value;
    const statusFilter = this.statusFilter.value;
    const typeFilter = this.typeFilter.value;
    let finalStartDate = null;
    let finalendDate = null;

    if (startDateFilter) {
      const startDateYear = startDateFilter.getFullYear();
      const startDateMonth = startDateFilter.getMonth() < 10 ? "0" + startDateFilter.getMonth() : startDateFilter.getMonth();
      const startDateDay = startDateFilter.getDate() < 10 ? "0" + startDateFilter.getDate() : startDateFilter.getDate();
      const startDateHour = startDateFilter.getHours() < 10 ? "0" + startDateFilter.getHours() : startDateFilter.getHours();
      const startDateMinute = startDateFilter.getMinutes() < 10 ? "0" + startDateFilter.getMinutes() : startDateFilter.getMinutes();
      const startDateSecond = startDateFilter.getSeconds() < 10 ? "0" + startDateFilter.getSeconds() : startDateFilter.getSeconds();
      finalStartDate = `${startDateYear}-${startDateMonth}-${startDateDay} ${startDateHour}:${startDateMinute}:${startDateSecond}`;
    }


    if (endDateFilter) {
      const endDateYear = endDateFilter.getFullYear();
      const endDateMonth = endDateFilter.getMonth() < 10 ? "0" + endDateFilter.getMonth() : endDateFilter.getMonth();
      const endDateDay = endDateFilter.getDate() < 10 ? "0" + endDateFilter.getDate() : endDateFilter.getDate();
      const endDateHour = endDateFilter.getHours() < 10 ? "0" + endDateFilter.getHours() : endDateFilter.getHours();
      const endDateMinute = endDateFilter.getMinutes() < 10 ? "0" + endDateFilter.getMinutes() : endDateFilter.getMinutes();
      const endDateSecond = endDateFilter.getSeconds() < 10 ? "0" + endDateFilter.getSeconds() : endDateFilter.getSeconds();
      finalendDate = `${endDateYear}-${endDateMonth}-${endDateDay} ${endDateHour}:${endDateMinute}:${endDateSecond}`;
    }

    const payload = {
      'job_status': statusFilter,
      'job_type': typeFilter,
      'start_date': finalStartDate,
      'end_date': finalendDate
    };

    const check = Object.keys(payload).filter((key) => payload[key] !== null);

    if (check.length < 1) {
      this.snackBar.open('Please fill atleast 1 filter', 'Close', {
        duration: 2000,
      });
      return;
    } else {
      const startCheck = check.includes('start_date');
      const endCheck = check.includes('end_date');
      const statusCheck = check.includes('job_status');
      const typeCheck = check.includes('job_type');

      if ((startCheck && !endCheck) || (endCheck && !startCheck)) {
        this.snackBar.open('Choose both dates', 'Close', {
          duration: 2000,
        });
        return; // throw message;
      } else {
        if (statusCheck) {
          this.payload.job_status = statusFilter;
        }
        if (typeCheck) {
          this.payload.job_type = typeFilter;
        }
        if (startCheck && endCheck) {
          this.payload.start_date = finalStartDate;
          this.payload.end_date = finalendDate;
          if (this.endDateFilter.value < this.startDateFilter.value) {
            this.snackBar.open('Choose proper end date', 'Close', {
              duration: 2000,
            });
            return; // throw message;
          }
        }
        console.log(this.payload);
        this.fetchRecords();
      }
    }
  }

  deletePost(id) {
    // show the progress bar
    this.deleteProgress = true;
    this._scheduler.deleteScheduledPosts(id).subscribe((data) => {
      this.snackBar.open('Deleted!', 'Close', {
        duration: 2000,
      });
      this.payload = <ScheduledPostsPayload>{};
      this.fetchRecords();
      this.deleteProgress = false;
    });
  }

  openDialog(id): void {
    const dialogRef = this.dialog.open(DialogSeePostDialogComponent, {
      width: '80%',
      data: id
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log(result);
    });
  }

}

@Component({
  selector: 'app-dialog-see-posts-dialog',
  templateUrl: 'dialog-overview-see-post.html',
})
export class DialogSeePostDialogComponent {

  pages: any = [];
  pagesSwitch: string;

  constructor(
    public dialogRef: MatDialogRef<DialogSeePostDialogComponent>,
    public _scheduler: SchedulerService,
    @Inject(MAT_DIALOG_DATA) public data) {
      this.pagesSwitch = 'loading';
      this._scheduler.getPagesScheduled(data).subscribe((response) => {
        console.log(response);
        this.pages = response.results;
        this.pagesSwitch = 'active';
      });
  }

}
