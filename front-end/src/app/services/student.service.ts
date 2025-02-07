import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class StudentService {
  private apiUrl = environment.apiUrl;
  private apiKey = environment.apiKey;

  constructor(private http: HttpClient) {}

  private getHeaders() {
    return {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'X-API-KEY': this.apiKey,
        'accept': 'application/json'
      })
    };
  }

  // endpoint para obtener grados con sus secciones
  getGradesAndSections(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/grados-secciones`, this.getHeaders()).pipe(
      catchError((error: HttpErrorResponse) => {
        return throwError(() => error);
      })
    );
  }

  // endpoint para obtener la lista de estudiantes
  getStudents(grade: string | null, section: string | null, page: number): Observable<any> {
    let url = `${this.apiUrl}/consultar-alumnos`;

    const queryParams = [];

    if (grade) queryParams.push(grade);
    if (section) queryParams.push(section);

    if (queryParams.length) url += `/${queryParams.join('/')}`;

    url += `?page=${page}`;

    return this.http.get<any>(url, this.getHeaders()).pipe(
      catchError((error: HttpErrorResponse) => {
        return throwError(() => error);
      })
    );
  }

  // endpoint para crear un nuevo estudiante
  createStudent(student: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/crear-alumno`, student, this.getHeaders()).pipe(
      catchError((error: HttpErrorResponse) => {
        return throwError(() => error);
      })
    );
  }

  // endpoint para actualizar información de un estudiante
  updateStudent(id: number, student: any): Observable<any> {
    return this.http.put<any>(`${this.apiUrl}/actualizar-alumno/${id}`, student, this.getHeaders()).pipe(
      catchError((error: HttpErrorResponse) => {
        return throwError(() => error);
      })
    );
  }
}
