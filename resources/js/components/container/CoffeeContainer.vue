<template>
  <BaseContainer
    :current="current"
    :capacity="capacity"
    :percentage="percentage"
    unit="g"
  >
    <template #content>
      <div
        class="absolute bottom-0 w-full overflow-hidden bg-linear-to-t from-orange-800 to-orange-700 bg-size-[20px_20px] bg-local bg-position-[0_0] bg-repeat transition-all duration-500 ease-out"
        :style="{ backgroundImage: POWDER_PATTERN, height: `${percentage}%` }"
      >
        <div
          class="absolute top-0 h-2 w-full bg-linear-to-b from-orange-700 to-transparent opacity-60"
        ></div>
      </div>
    </template>

    <template #fill-form>
      <FillForm
        label="Coffee"
        unit="g"
        color="#B55309"
        :current="current"
        :capacity="capacity"
        :loading="store.loading"
        @fill="(qty: number) => store.fill('coffee', qty)"
        @empty="() => store.empty('coffee')"
      />
    </template>
  </BaseContainer>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import BaseContainer from '@/components/container/BaseContainer.vue';
import FillForm from '@/components/FillForm.vue';
import { useMachineStore } from '@/stores/machine';

const POWDER_PATTERN = `url("data:image/svg+xml,%3Csvg width='20' height='20' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='20' height='20' fill='%23b45309'/%3E%3Ccircle cx='4' cy='5' r='1.2' fill='rgba(0,0,0,0.2)'/%3E%3Ccircle cx='14' cy='3' r='0.8' fill='rgba(0,0,0,0.15)'/%3E%3Ccircle cx='8' cy='12' r='1.1' fill='rgba(0,0,0,0.18)'/%3E%3Ccircle cx='16' cy='14' r='0.9' fill='rgba(0,0,0,0.16)'/%3E%3Ccircle cx='2' cy='17' r='1' fill='rgba(0,0,0,0.17)'/%3E%3Ccircle cx='18' cy='18' r='0.7' fill='rgba(0,0,0,0.14)'/%3E%3C/svg%3E")`;

const store = useMachineStore();
const current = computed(() => store.status.coffee?.current as number);
const capacity = computed(() => store.status.coffee?.capacity as number);
const percentage = computed(() => store.status.coffee?.percentage as number);
</script>
