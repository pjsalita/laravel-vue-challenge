<template>
  <div class="flex flex-col gap-3 p-5" :style="{ '--btn-color': color }">
    <div class="flex items-center gap-2">
      <span class="text-[0.65rem] font-normal tracking-[0.18em] uppercase">
        {{ name }}
      </span>
    </div>
    <div class="grid grid-cols-2 gap-2">
      <button
        type="button"
        class="min-w-[60px] rounded border bg-transparent px-4 py-2 font-mono text-[0.6rem] tracking-[0.15em] transition"
        :class="{
          'border-(--btn-color) text-(--btn-color)': color,
          'cursor-not-allowed opacity-35': loading || !canFillFull,
          'cursor-pointer hover:bg-white/5': !loading && canFillFull,
        }"
        :disabled="loading || !canFillFull"
        @click="fillFull"
      >
        Fill to full
      </button>
      <button
        type="button"
        class="min-w-[60px] rounded border bg-transparent px-4 py-2 font-mono text-[0.6rem] tracking-[0.15em] transition"
        :class="{
          'border-(--btn-color) text-(--btn-color)': color,
          'cursor-not-allowed opacity-35': loading || !canEmpty,
          'cursor-pointer hover:bg-black/5': !loading && canEmpty,
        }"
        :disabled="loading || !canEmpty"
        @click="emit('empty')"
      >
        Empty
      </button>
    </div>
    <div class="flex gap-2">
      <input
        v-model.number="quantity"
        ref="inputRef"
        type="number"
        :min="1"
        :placeholder="`Amount in ${unit}`"
        class="flex-1 rounded border border-(--btn-color) px-3 py-2 font-mono text-[0.8rem] text-(--btn-color) transition-colors duration-200 outline-none"
        @keyup.enter="submit"
        @blur="(e) => ((e.target as HTMLInputElement).style.borderColor = '')"
        autocomplete="off"
      />
      <button
        class="min-w-[60px] rounded border px-4 py-2 font-mono text-[0.6rem] tracking-[0.15em] transition"
        :class="{
          'border-(--btn-color) text-(--btn-color)': color,
          'cursor-not-allowed opacity-35':
            !quantity || quantity <= 0 || loading,
          'cursor-pointer hover:bg-white/5':
            quantity && quantity > 0 && !loading,
        }"
        :disabled="!quantity || quantity <= 0 || loading"
        @click="submit"
      >
        <span v-if="!loading">FILL</span>
        <span
          v-else
          class="inline-block h-2.5 w-2.5 animate-spin rounded-full border border-current border-t-transparent"
        ></span>
      </button>
    </div>
    <p class="text-[0.55rem] tracking-[0.06em]">Enter amount in {{ unit }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import type { FillFormProps } from '@/types';

const emit = defineEmits(['fill', 'empty']);

const props = withDefaults(defineProps<FillFormProps>(), {
  current: 0,
  capacity: 0,
  percentage: 0,
  loading: false,
});

const quantity = ref<number | null>(null);
const canFillFull = computed(
  () =>
    props.capacity != null &&
    props.current != null &&
    props.current < props.capacity,
);
const canEmpty = computed(() => props.current != null && props.current > 0);

const submit = () => {
  if (!quantity.value || quantity.value <= 0) {
    return;
  }

  emit('fill', quantity.value);
};

const fillFull = () => {
  if (!canFillFull.value) {
    return;
  }

  const amount = props.capacity - props.current;

  if (amount <= 0) {
    return;
  }

  emit('fill', amount);
};

const inputRef = ref<HTMLInputElement | null>(null);
onMounted(() => inputRef.value?.focus());
</script>
