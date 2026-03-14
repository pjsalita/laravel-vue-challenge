<template>
  <div class="absolute top-1/2 left-1/2 z-20 flex -translate-1/2 gap-2">
    <button
      v-for="drink in store.drinks"
      :key="drink.id"
      type="button"
      class="relative flex h-10 w-10 cursor-pointer items-center justify-center rounded-full border-2 border-slate-700 bg-slate-200 text-slate-700 transition hover:bg-slate-300 focus:ring-2 focus:ring-slate-700 focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
      :disabled="store.active || store.loading"
      v-tooltip.top="tooltipOptions(drink)"
      @click="store.brew(drink)"
    >
      <span
        v-if="drink.icon"
        v-html="drink.icon"
        class="flex items-center justify-center"
        aria-hidden="true"
      ></span>
      <Coffee v-else class="size-5" />
    </button>
  </div>
</template>

<script setup lang="ts">
import { Coffee } from 'lucide-vue-next';
import Tooltip from 'primevue/tooltip';
import { useMachineStore } from '@/stores/machine';
import type { Drink } from '@/types';

defineOptions({ directives: { tooltip: Tooltip } });
defineEmits(['brew']);

const store = useMachineStore();
function tooltipOptions(drink: Drink) {
  return {
    value: `<p>${drink.label}</p><small class="text-xs text-neutral-400 block">Water: ${drink.waterMl}ml</small><small class="text-xs text-neutral-400">Coffee: ${drink.coffeeGrams}g</small>`,
    escape: false,
  };
}
</script>
