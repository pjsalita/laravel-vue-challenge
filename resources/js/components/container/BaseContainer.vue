<template>
  <div class="w-50 max-w-1/2">
    <div
      class="relative h-50 w-full overflow-hidden rounded-3xl rounded-b-none border-7 border-b-0 border-slate-700 bg-slate-100"
    >
      <slot name="content"></slot>

      <div
        class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center"
      >
        <div class="text-5xl font-bold text-slate-700">{{ percentage }}%</div>
        <div class="text-sm text-slate-800">
          {{ current }} / {{ capacity }} {{ unit }}
        </div>
      </div>

      <button
        type="button"
        class="pointer-events-auto absolute top-2 right-2 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full border-2 border-slate-700 bg-slate-200 text-slate-700 shadow transition hover:bg-slate-300"
        @click="popoverRef?.toggle($event)"
      >
        <Plus />
      </button>
    </div>
  </div>
  <Popover ref="popoverRef">
    <slot name="fill-form"></slot>
  </Popover>
</template>

<script setup lang="ts">
import { Plus } from 'lucide-vue-next';
import Popover from 'primevue/popover';
import { ref } from 'vue';
import type { ContainerProps } from '@/types';

withDefaults(defineProps<ContainerProps>(), {
  current: 0,
  capacity: 0,
  percentage: 0,
  unit: '',
});

const popoverRef = ref<InstanceType<typeof Popover> | null>(null);
</script>
