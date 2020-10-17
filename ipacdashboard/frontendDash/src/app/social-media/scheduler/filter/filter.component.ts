/**
 * @author victor
 */
import {
  Component,
  OnInit,
  Output,
  Input,
  EventEmitter,
  ViewChild,
  ElementRef
} from '@angular/core';
import { STATES } from "../../../states-districts";
@Component({
  selector: 'app-filter',
  templateUrl: './filter.component.html',
  styleUrls: ['./filter.component.css']
})
export class FilterComponent implements OnInit {

  states = STATES;
  districts = [];
  selectedStateModel = '';
  selectedDistrictModel = '';

  @Output() searchRecords = new EventEmitter<any>();
  @Output() selectState = new EventEmitter<any>();
  @Output() selectDistrict = new EventEmitter<any>();
  @Output() clearFilter = new EventEmitter<any>();

  private _clearCriteria;

  @Input()
  set clearCriteria(value: any) {
    this.resetSelectFilters();
    this.resetInputFilter();
    this._clearCriteria = value;
  }
  get clearCriteria(): any { return this._clearCriteria; }

  @ViewChild('query') input: ElementRef;

  constructor() { }

  ngOnInit() {
  }

  mapDistricts(event) {
    this.resetInputFilter();
    const currentObject = this.states.filter((state) => {
      return state.state === event.value;
    }).pop();
    this.districts = currentObject.districts;
    this.selectState.emit(event.value);
  }

  onKey(value: string) {
    this.resetSelectFilters();
    this.searchRecords.emit(value);
  }

  filterData(event) {
    this.resetInputFilter();
    this.selectDistrict.emit(event.value);
  }

  clearFilters() {
    this.resetSelectFilters();
    this.resetInputFilter();
    this.clearFilter.emit();
  }

  resetSelectFilters(): void {
    this.selectedStateModel = '';
    this.selectedDistrictModel = '';
    this.districts = [];
  }

  resetInputFilter(): void {
    this.input.nativeElement.value = '';
  }

}
