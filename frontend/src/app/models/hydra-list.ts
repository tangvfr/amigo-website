export interface HydraList<T> {
  readonly 'hydra:totalItems': number;
  readonly 'hydra:member': T[];
}

export const EMPTY_HYDRA_LIST: HydraList<any> = {
  'hydra:member': [],
  'hydra:totalItems': 0,
};
