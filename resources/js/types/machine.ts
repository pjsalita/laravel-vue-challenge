export type ContainerTypes = 'water' | 'coffee';

export interface ContainerProps {
  current: number;
  capacity: number;
  percentage?: number;
  unit?: string;
}

export interface FillFormProps {
  label: string;
  unit: string;
  color: string;
  loading: boolean;
  current: number;
  capacity: number;
}

export interface MachineStatus {
  water: ContainerProps;
  coffee: ContainerProps;
  drinks?: {
    [key: string]: DrinkReadiness;
  };
}

export type DrinkReadiness =
  | 'ready'
  | 'insufficient_water'
  | 'insufficient_coffee'
  | 'insufficient_water_and_coffee';

export interface Drink {
  id: string;
  slug: string;
  label: string;
  waterMl: number;
  coffeeGrams: number;
  active: boolean;
  icon?: string;
}
