<template>
  <div class="machine-page">
    <h1 class="font-display mb-4 text-2xl font-bold">
      Welcome to Coffee Machine
    </h1>

    <div class="machine-page__containers">
      <WaterContainer />
      <CoffeeContainer />
    </div>

    <div class="machine-page__machine group" :class="{ active: store.active }">
      <div class="machine__top-upper">
        <p class="m-0 mt-4 text-center text-sm text-white">
          Choose your coffee below.
        </p>

        <BrewButtons />

        <div class="machine__highlight--default"></div>
        <div class="machine__shadow--default"></div>
      </div>

      <div class="machine__top-lower"></div>

      <div class="machine__middle">
        <div class="machine__highlight--default"></div>
        <div class="machine__shadow--default"></div>

        <div class="machine__dispenser">
          <div class="machine__dispenser-handle"></div>
          <div class="machine__dispenser-spout">
            <div class="machine__highlight--spout"></div>
            <div class="machine__shadow--spout"></div>
          </div>
          <div class="machine__highlight--spout"></div>
          <div class="machine__shadow--spout"></div>
          <div class="machine__dispenser-coffee"></div>
        </div>

        <div class="machine__cup">
          <div class="machine__cup-fill"></div>
          <div class="machine__highlight--cup"></div>
          <div class="machine__shadow--cup"></div>
          <div class="machine__cup-steam--left"></div>
          <div class="machine__cup-steam--right"></div>
        </div>
      </div>

      <div class="machine__base">
        <div class="machine__highlight--default"></div>
        <div class="machine__shadow--default"></div>

        <CheckStatus />
      </div>

      <div class="machine__counter"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useToast } from 'primevue/usetoast';
import { onMounted } from 'vue';
import BrewButtons from '@/components/BrewButtons.vue';
import CheckStatus from '@/components/CheckStatus.vue';
import CoffeeContainer from '@/components/container/CoffeeContainer.vue';
import WaterContainer from '@/components/container/WaterContainer.vue';
import { useMachineStore } from '@/stores/machine';

const store = useMachineStore();
const toast = useToast();

onMounted(() => {
  store.setToast(toast);
  store.fetchDrinks();
  store.fetchStatus();
});
</script>

<style scoped>
@reference "tailwindcss";

.machine-page {
  @apply relative mx-auto flex min-h-screen flex-col items-center justify-center p-4;
}

.machine-page__containers {
  @apply flex justify-center gap-2;
}

.machine-page__machine {
  @apply relative mx-auto block h-[500px] w-[700px] max-w-full **:box-content [&_*::after]:box-content [&_*::before]:box-content;
}

.machine__top-upper {
  @apply absolute top-0 left-1/2 z-10 h-[25%] w-[70%] -translate-x-1/2 overflow-hidden rounded-t-xl rounded-b-[40px] border-[7px] border-solid border-slate-700 bg-zinc-700;
}

.machine__highlight--default {
  @apply absolute top-0 left-0 h-full w-[5%] bg-white/15;
}

.machine__shadow--default {
  @apply absolute top-0 right-0 h-full w-[5%] bg-black/10;
}

.machine__highlight--spout {
  @apply absolute top-0 left-0 h-full w-[20%] rounded-br-[12px] bg-white/15;
}

.machine__shadow--spout {
  @apply absolute top-0 right-0 h-full w-[20%] rounded-br-[12px] bg-black/10;
}

.machine__highlight--cup {
  @apply absolute top-0 left-0 h-full w-[15%] rounded-bl-[12px] bg-white/15;
}

.machine__shadow--cup {
  @apply absolute top-0 right-0 h-full w-[15%] rounded-br-[12px] bg-black/10;
}

.machine__top-lower {
  @apply absolute top-[25%] left-1/2 z-8 h-[5%] w-[60%] -translate-x-1/2 rounded-b-[20px] border-[7px] border-solid border-slate-700 bg-zinc-400;
}

.machine__middle {
  @apply absolute top-[30%] left-1/2 z-6 h-[46%] w-1/2 -translate-x-1/2 border-[7px] border-solid border-slate-700 bg-zinc-700;
}

.machine__dispenser {
  @apply absolute left-1/2 h-1/4 w-1/5 -translate-x-1/2 rounded-b-[20px] border-[7px] border-solid border-gray-600 bg-zinc-400 after:absolute after:top-0 after:left-0 after:h-[15%] after:w-full after:border-b-[7px] after:border-solid after:border-gray-600 after:bg-zinc-400 after:content-[''];
}

.machine__dispenser-handle {
  @apply absolute top-1/5 right-full z-10 h-1/5 w-full rounded-l-[50px] border-[7px] border-solid border-gray-600 bg-zinc-400;
}

.machine__dispenser-spout {
  @apply absolute top-full left-[14%] z-10 h-[10%] w-1/2 rounded-b-[5px] border-[7px] border-solid border-gray-600 bg-zinc-400 after:absolute after:top-full after:left-1/5 after:z-10 after:h-full after:w-1/5 after:rounded-b-[5px] after:border-[7px] after:border-solid after:border-gray-600 after:bg-zinc-400 after:content-[''];
}

.machine__dispenser-coffee {
  @apply absolute top-full bottom-0 left-[44%] z-1 w-[11%] rounded-[50px] bg-orange-950 transition-all duration-300 group-[.active]:animate-[pourCoffee_1s_linear_1_forwards];
}

.machine__cup {
  @apply absolute bottom-[-3%] left-1/2 z-10 h-[35%] w-1/5 -translate-x-1/2 rounded-[10px] rounded-b-[20px] border-[7px] border-solid border-gray-600 bg-white/50 opacity-0 transition-opacity duration-300 group-[.active]:opacity-100 after:absolute after:top-1/5 after:right-[-40%] after:h-[45%] after:w-1/5 after:rounded-r-[10px] after:border-[7px] after:border-solid after:border-gray-600 after:content-[''];
}

.machine__cup-fill {
  @apply absolute right-[12%] bottom-0 left-[12%] h-0 rounded-b-[10px] bg-linear-to-t from-orange-950 to-orange-900 group-[.active]:animate-[fillCup_1s_linear_1_forwards];
}

.machine__cup-steam--left {
  @apply absolute top-[-50%] left-[15%] h-[30%] w-[11%] rounded-[50px] bg-slate-400 opacity-0 transition-all duration-300 [animation-delay:0.12s] group-[.active]:animate-[steam_0.8s_linear_4_forwards];
}

.machine__cup-steam--right {
  @apply absolute top-[-40%] right-[20%] h-[30%] w-[10%] rounded-[50px] bg-slate-400 opacity-0 transition-all duration-300 [animation-delay:0.16s] group-[.active]:animate-[steam_0.8s_linear_4_forwards];
}

.machine__base {
  @apply absolute bottom-[5%] left-[15%] z-10 h-[15%] w-[70%] overflow-hidden rounded-t-xl border-[7px] border-solid border-slate-700 bg-zinc-700 before:absolute before:top-0 before:left-0 before:h-[10%] before:w-full before:border-b-[7px] before:border-solid before:border-slate-700 before:bg-zinc-400 before:content-[''];
}

.machine__counter {
  @apply absolute bottom-[5%] left-0 z-10 h-0 w-full overflow-hidden rounded-[50px] border-b-[7px] border-solid border-slate-700 bg-zinc-700;
}

@keyframes fillCup {
  0% {
    height: 0;
  }
  100% {
    height: 90%;
  }
}
@keyframes steam {
  0%,
  10% {
    opacity: 0;
    transform: translateY(0);
  }
  50% {
    opacity: 1;
    transform: translateY(-10px);
  }
  90%,
  100% {
    opacity: 0;
    transform: translateY(-20px);
  }
}
@keyframes pourCoffee {
  0% {
    top: 100%;
    bottom: 0%;
  }
  6%,
  94% {
    top: 100%;
    bottom: -300%;
  }
  100% {
    top: 300%;
    bottom: -300%;
  }
}
</style>
