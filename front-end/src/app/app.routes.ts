import { Routes } from '@angular/router';

import { StudentComponent } from './components/student/student.component';

export const routes: Routes = [
  { path: '', redirectTo: 'alumnos', pathMatch: 'full' },
  { path: 'alumnos', component: StudentComponent },
];
