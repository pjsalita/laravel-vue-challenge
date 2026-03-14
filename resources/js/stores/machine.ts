import { defineStore } from 'pinia';
import type { ToastServiceMethods } from 'primevue/toastservice';
import api from '@/lib/api';
import { getErrorMessage } from '@/lib/utils';
import type { ContainerTypes, Drink, MachineStatus } from '@/types';

const TOAST_DURATION = 3000;

export const useMachineStore = defineStore('machine', {
  state: () => ({
    status: {} as MachineStatus,
    drinks: [] as Drink[],
    loading: false,
    active: false,
    toast: null as ToastServiceMethods | null,
  }),
  actions: {
    setToast(toast: ToastServiceMethods) {
      this.toast = toast;
    },
    async fetchDrinks() {
      try {
        const { data } = await api.get<Drink[]>('/machine/drinks');
        this.drinks = data;
      } catch (e: unknown) {
        this.toast?.add({
          severity: 'error',
          summary: 'Error',
          detail: getErrorMessage(e, 'Could not load available drinks.'),
          life: TOAST_DURATION,
        });
      }
    },
    async fetchStatus() {
      try {
        const { data } = await api.get<MachineStatus>('/machine/status');
        this.status = data;
      } catch (e: unknown) {
        this.toast?.add({
          severity: 'error',
          summary: 'Error',
          detail: getErrorMessage(e, 'Could not load machine status.'),
          life: TOAST_DURATION,
        });
      }
    },
    async brew(drink: Drink) {
      this.loading = true;

      try {
        const { data } = await api.post(`/machine/brew/${drink.id}`);
        this.active = true;
        this.status = data.remaining;
        this.toast?.add({
          severity: 'success',
          summary: 'Success',
          detail: data.message,
          life: TOAST_DURATION,
        });
        setTimeout(() => (this.active = false), 1000);
      } catch (e: unknown) {
        this.toast?.add({
          severity: 'error',
          summary: 'Error',
          detail: getErrorMessage(e, 'Could not brew.'),
          life: TOAST_DURATION,
        });
      } finally {
        this.loading = false;
      }
    },
    async fill(type: ContainerTypes, quantity: number) {
      this.loading = true;

      try {
        const { data } = await api.post(`/machine/fill/${type}`, {
          quantity,
        });
        this.toast?.add({
          severity: 'success',
          summary: 'Success',
          detail: data.message,
          life: TOAST_DURATION,
        });

        if (this.status && data[type]) {
          this.status = { ...this.status, [type]: data[type] };
        }
      } catch (e: unknown) {
        this.toast?.add({
          severity: 'error',
          summary: 'Error',
          detail: getErrorMessage(e, 'Could not fill container.'),
          life: TOAST_DURATION,
        });
      } finally {
        this.loading = false;
      }
    },
    async empty(type: ContainerTypes) {
      this.loading = true;

      try {
        const { data } = await api.post(`/machine/empty/${type}`);
        this.toast?.add({
          severity: 'success',
          summary: 'Success',
          detail: data.message,
          life: TOAST_DURATION,
        });

        if (this.status && data[type]) {
          this.status = { ...this.status, [type]: data[type] };
        }
      } catch (e: unknown) {
        this.toast?.add({
          severity: 'error',
          summary: 'Error',
          detail: getErrorMessage(e, 'Could not empty container.'),
          life: TOAST_DURATION,
        });
      } finally {
        this.loading = false;
      }
    },
  },
});
