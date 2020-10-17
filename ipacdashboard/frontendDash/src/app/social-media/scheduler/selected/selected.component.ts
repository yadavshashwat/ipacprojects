/**
 * @author victor
 * selected records compoennt
 */
import {
  Component,
  OnInit,
  Input,
  OnChanges,
  SimpleChanges,
  Output,
  EventEmitter
} from '@angular/core';

@Component({
  selector: 'app-selected',
  templateUrl: './selected.component.html',
  styleUrls: ['./selected.component.css']
})
export class SelectedComponent implements OnInit, OnChanges {

  selectable = true;
  removable = true;
  selectedrecords: any[] = [];
  selectedSwitch: string;

  @Input() selectedRecord: any;
  @Output() emitToScheduler = new EventEmitter<any>();
  @Output() emitToForm = new EventEmitter<any>();
  @Output() emitRecordsToForm = new EventEmitter<any>();

  constructor() {
    this.selectedSwitch = 'initial';
  }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges) {
    // first change ignore
    if (changes.selectedRecord.firstChange) {
      return;
    }
    // capture the current value
    const currentRecord = changes.selectedRecord.currentValue;
    this.addToSelectedRecords(currentRecord);

  }

  addToSelectedRecords(currentRecord) {
    if (!currentRecord) {
      return;
    }
    this.selectedrecords.push(this.selectedRecord);
    this.selectedSwitch = 'active';
    this.emitToScheduler.emit(this.selectedrecords);
    if (this.selectedrecords.length > 0) {
      this.emitToForm.emit(true);
      this.emitRecordsToForm.emit(this.selectedrecords);
    } else {
      this.emitToForm.emit(false);
      this.emitRecordsToForm.emit([]);
    }
  }

  removeSelectedRecord(record) {
    const index = this.selectedrecords.indexOf(record);

    if (index >= 0) {
      this.selectedrecords.splice(index, 1);
      this.emitToScheduler.emit(this.selectedrecords);
      this.emitToForm.emit(true);
      this.emitRecordsToForm.emit(this.selectedrecords);
    }

    if (this.selectedrecords.length === 0) {
      this.selectedSwitch = 'initial';
      this.emitToForm.emit(false);
      this.emitRecordsToForm.emit([]);
    }
  }

}
