<template>
  <button
    type="button"
    class="absolute bottom-2 left-1/2 z-20 -translate-x-1/2 cursor-pointer rounded-lg border-2 border-slate-600 bg-zinc-500 px-3 py-1.5 text-sm font-medium text-white shadow transition hover:bg-zinc-600"
    @click="checkStatus($event)"
  >
    Check Status
  </button>

  <Popover ref="popoverRef">
    <div v-if="store.status" class="min-w-48">
      <h3 class="m-0 mb-2 text-base font-semibold">Machine Status</h3>
      <dl class="grid grid-cols-[auto_1fr] gap-x-3 gap-y-1 text-sm">
        <dt>Water</dt>
        <dd :class="levelClass(store.status.water)">
          {{ store.status.water?.current ?? 0 }} /
          {{ store.status.water?.capacity ?? 0 }} ml ({{
            store.status.water?.percentage
          }}%)
        </dd>
        <dt>Coffee</dt>
        <dd :class="levelClass(store.status.coffee)">
          {{ store.status.coffee?.current ?? 0 }} /
          {{ store.status.coffee?.capacity ?? 0 }} g ({{
            store.status.coffee?.percentage
          }}%)
        </dd>
      </dl>

      <template
        v-if="store.status.drinks && Object.keys(store.status.drinks).length"
      >
        <h4 class="m-0 mt-2 mb-1 text-sm font-medium">Drinks</h4>
        <ul class="m-0 list-inside list-disc p-0 text-sm">
          <li
            v-for="[drinkId, readiness] in drinkEntries"
            :key="drinkId"
            :class="readinessClass(readiness)"
          >
            {{ drinkLabel(drinkId) }} — {{ readinessLabel(readiness) }}
          </li>
        </ul>
      </template>
    </div>
    <p v-else class="m-0 text-sm text-zinc-500">No status data.</p>
  </Popover>
</template>

<script setup lang="ts">
import Popover from 'primevue/popover';
import { computed, ref } from 'vue';
import { useMachineStore } from '@/stores/machine';

import type { ContainerProps, DrinkReadiness } from '@/types';

const store = useMachineStore();

const LOW_LEVEL_PERCENT = 30;

const levelClass = (container: ContainerProps | undefined): string => {
  return (container?.percentage || 0) <= LOW_LEVEL_PERCENT
    ? 'text-red-600'
    : 'text-green-600';
};

const readinessLabel = (r: DrinkReadiness | undefined): string => {
  if (!r || r === 'ready') {
    return 'Ready';
  }

  if (r === 'insufficient_water') {
    return 'Insufficient Water';
  }

  if (r === 'insufficient_coffee') {
    return 'Insufficient Coffee';
  }

  return 'Insufficient Water & Coffee';
};

const readinessClass = (
  r: DrinkReadiness | undefined,
): Record<string, boolean> => {
  const ready = r === 'ready';

  return {
    'text-green-600': ready,
    'text-red-600': !ready && r !== undefined,
  };
};

const drinkLabel = (drinkId: string): string => {
  const drinks = store.drinks;
  const byId = drinks.find((d) => d.id === drinkId);

  if (byId) {
    return byId.label;
  }

  const bySlug = drinks.find((d) => d.slug === drinkId);

  return bySlug?.label ?? '';
};

const popoverRef = ref<InstanceType<typeof Popover> | null>(null);

const drinkEntries = computed(() =>
  store.status.drinks ? Object.entries(store.status.drinks) : [],
);

const checkStatus = (e: Event) => {
  popoverRef.value?.toggle(e);
  store.fetchStatus();
};
</script>
