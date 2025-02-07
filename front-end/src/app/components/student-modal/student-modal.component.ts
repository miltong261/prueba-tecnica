import { Component, Input, Output, EventEmitter, OnInit, input } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { StudentService } from '../../services/student.service';

@Component({
  selector: 'app-student-modal',
  imports: [CommonModule,FormsModule],
  templateUrl: './student-modal.component.html',
  styleUrl: './student-modal.component.css'
})
export class StudentModalComponent implements OnInit {
  @Input() isModalOpen: boolean = false;
  @Input() student: any = {};
  @Input() grades: any[] = [];
  @Input() sections: any[] = [];
  @Input() gradeId: string = '';
  @Output() lock = new EventEmitter<void>();
  @Output() closeModal = new EventEmitter<{message: string, success: boolean, show: boolean}>();

  formErrors: any = {};

  loading: boolean = false;

  constructor(private studentService: StudentService) {}

  ngOnInit() {
    this.onGradeChange()
  }

  onGradeChange() {
    this.student.section_id = this.student.section_id && this.gradeId == this.student.grade_id ? this.student.section_id : '';
    const gradeSelected = this.grades.find((g) => g.id == this.student.grade_id);
    this.sections = gradeSelected ? gradeSelected.sections : [];
  }

  close(message: string = '', success: boolean = false, show: boolean = false) {
    this.formErrors = {};
    this.closeModal.emit({ message, success, show });
  }

  onSubmit() {
    if (this.student.id) {
      this.updateStudent();
    } else {
      this.createStudent();
    }
  }

  createStudent() {
    this.loading = true;

    this.studentService.createStudent(this.student).subscribe({
      next: (response) => {
        this.loading = false;

        this.close(response.message, response.success, true);
      },
      error: (error: any) => {
        this.loading = false;

        if (error.status && error.status === 401) {
          this.lock.emit;
        } else if (error.status && error.status === 422) {
          this.handleValidationErrors(error.error.errors);
        } else {
          this.close(error.error?.error || error.error?.message || 'Ocurrío un error inesperado', false, true);
        }
      }
    });
  }

  updateStudent() {
    this.loading = true;

    this.studentService.updateStudent(this.student.id, this.student).subscribe({
      next: (response) => {
        this.loading = false;

        this.close(response.message, response.success, true);
      },
      error: (error: any) => {
        this.loading = false;

        if (error.status && error.status === 401) {
          this.lock.emit;
        } else if (error.status && error.status === 422) {
          this.handleValidationErrors(error.error.errors);
        } else {
          this.close(error.error?.error || error.error?.message || 'Ocurrío un error inesperado', false, true);
        }
      }
    });
  }

  handleValidationErrors(errors: any) {
    for (const field in errors) {
      if (errors.hasOwnProperty(field)) {
        this.formErrors[field] = errors[field][0];
      }
    }
  }

}
