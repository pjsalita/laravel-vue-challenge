export type ContainerTypes = 'water' | 'coffee';

export interface Container {
  id: number | string;
  type: ContainerTypes;
  name: string;
  current: number;
  capacity: number;
  unit: string;
}

export type ContainerProps = Container & {
  percentage?: number;
};

export interface FillFormProps {
  name: string;
  color: string;
  loading: boolean;
  current: number;
  capacity: number;
  unit: string;
}

export interface MachineStatus {
  containers: {
    [key in ContainerTypes]: ContainerProps;
  };
  drinks?: {
    [key: string]: DrinkStatus;
  };
}

export interface DrinkStatus {
  enough_water: boolean;
  enough_coffee: boolean;
}

export interface Drink {
  id: number | string;
  slug: string;
  name: string;
  water: number;
  water_unit: string;
  coffee: number;
  coffee_unit: string;
  active: boolean;
  icon?: string;
}
