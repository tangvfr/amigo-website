import {Student} from "./student";
import {Role} from "./role";

export interface Post {
  readonly role: Role
  readonly student: Student
}
