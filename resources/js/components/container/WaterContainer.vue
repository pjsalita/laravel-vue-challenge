<template>
  <BaseContainer
    id="water"
    type="water"
    name="Water"
    :current="current"
    :capacity="capacity"
    :percentage="percentage"
    :unit="store.status.containers?.water?.unit"
  >
    <template #content>
      <div
        class="absolute bottom-0 w-full bg-linear-to-t from-blue-500 to-blue-400 transition-all duration-500 ease-out"
        :style="{ height: `${percentage}%` }"
      >
        <div class="absolute inset-0 opacity-30">
          <svg
            class="h-full w-full"
            viewBox="0 0 1200 120"
            preserveAspectRatio="none"
          >
            <path
              class="wave-path"
              d="M0,50 Q300,20 600,50 T1200,50 L1200,120 L0,120 Z"
            />
          </svg>
        </div>
      </div>
    </template>

    <template #fill-form>
      <FillForm
        name="Water"
        unit="L"
        color="#004D7F"
        :current="current"
        :capacity="capacity"
        :loading="store.loading"
        @fill="(qty: number) => store.fill('water', qty)"
        @empty="() => store.empty('water')"
      />
    </template>
  </BaseContainer>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import BaseContainer from '@/components/container/BaseContainer.vue';
import FillForm from '@/components/FillForm.vue';
import { useMachineStore } from '@/stores/machine';

const store = useMachineStore();
const current = computed(
  () => store.status.containers?.water?.current as number,
);
const capacity = computed(
  () => store.status.containers?.water?.capacity as number,
);
const percentage = computed(
  () => store.status.containers?.water?.percentage as number,
);
</script>

<style scoped>
@reference "tailwindcss";

.wave-path {
  @apply animate-[wave_4s_ease-in-out_infinite] fill-white/30;
}

@keyframes wave {
  0%,
  100% {
    d: path('M0,50 Q300,20 600,50 T1200,50 L1200,120 L0,120 Z');
  }
  50% {
    d: path('M0,70 Q300,100 600,70 T1200,70 L1200,120 L0,120 Z');
  }
}
</style>
