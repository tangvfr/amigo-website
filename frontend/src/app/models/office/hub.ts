import {Post} from "./post";

export interface Hub {
  readonly id: number
  readonly name: string
  readonly description: string;
  readonly composition: Set<Post>;
}
