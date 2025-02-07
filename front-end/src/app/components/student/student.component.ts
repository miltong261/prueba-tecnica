import { Component, OnInit, ViewChild } from '@angular/core';
import { CommonModule } from '@angular/common';
import { StudentService } from '../../services/student.service';
import { FormsModule } from '@angular/forms';
import { StudentModalComponent } from '../student-modal/student-modal.component';
import { NgxPaginationModule } from 'ngx-pagination';

@Component({
  selector: 'app-student',
  imports: [CommonModule, FormsModule, StudentModalComponent, NgxPaginationModule],
  templateUrl: './student.component.html',
  styleUrl: './student.component.css'
})
export class StudentComponent implements OnInit {
  unauthorized: boolean = false;

  isModalOpen: boolean = false;

  students: any[] = [];

  infoStudent: any = {
    first_name: '',
    last_name: '',
    date_of_birth: '',
    father_name: '',
    mother_name: '',
    grade_id: '',
    section_id: '',
    enrollment_date: '',
    status: ''
  };

  gradeId: string = '';

  selectedStudent: any = null;

  p: number = 1;
  currentPage: number = 1;
  totalItems: number = 0;
  itemsPerPage: number = 5;

  grades: any[] = [];
  gradeSelect: string = '';

  sections: any[] = [];
  sectionSelect: string = '';

  errorMessage: string | null = null;
  successMessage: string | null = null;

  loading: boolean = false;

  @ViewChild(StudentModalComponent) modalComponent: StudentModalComponent | undefined;

  constructor(private studentService: StudentService) {}

  ngOnInit() {
    this.getGradesAndSections();
  }

  lock() {
    this.unauthorized = true;
  }

  createOrEdit(student: any = null) {
    this.selectedStudent = student;
    this.infoStudent = { ...student };
    this.gradeId = student ? student.grade_id : '';
    this.isModalOpen = true;
  }

  closeModal(event: { message: string | null; success: boolean | false; show: boolean | false}) {
    this.selectedStudent = null;

    this.infoStudent = {
      first_name: '',
      last_name: '',
      date_of_birth: '',
      father_name: '',
      mother_name: '',
      grade_id: '',
      section_id: '',
      enrollment_date: '',
      status: ''
    };

    if (event.show) {
      if (event.success) {
        this.successMessage = event.message;

        this.getStudents();
      } else {
        this.errorMessage = event.message;
      }

      setTimeout(() => {
        this.successMessage = null;
        this.errorMessage = null;
      }, 2000);
    }

    this.isModalOpen = false;
  }

  getGradesAndSections() {
    this.loading = true;

    this.studentService.getGradesAndSections().subscribe({
      next: (response) => {
        this.loading = false;

        this.grades = response.data.grades;
      },
      error: (error) => {
        this.loading = false;

        if (error.status === 401) {
          this.lock();
        }

        this.errorMessage = error.error?.error || error.error?.message || 'Ocurrío un error inesperado'
      },
    });
  }

  onGradeChangeForSearch() {
    this.sectionSelect = '';
    const gradeSelected = this.grades.find((g) => g.id == this.gradeSelect);
    this.sections = gradeSelected ? gradeSelected.sections : [];
  }

  getStudents(page: number = 1) {
    this.loading = true;

    this.studentService.getStudents(this.gradeSelect, this.sectionSelect, page).subscribe({
      next: (response) => {
        this.loading = false;

        this.students = response.data.students;
        this.currentPage = response.data.current_page;
        this.totalItems = response.data.total;
        this.itemsPerPage = response.data.per_page;
      },
      error: (error) => {
        this.loading = false;

        if (error.status === 401) {
          this.lock();
        }

        this.errorMessage = error.error?.error || error.error?.message || 'Ocurrío un error inesperado'
      },
    });
  }

  onPageChange(page: number) {
    this.getStudents(page)
  }
}
