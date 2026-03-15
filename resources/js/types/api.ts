export interface ApiResponse<T> {
  data: T;
  message:
    | string
    | {
        [key: string]: string[];
      };
  [key: string]: unknown;
}
