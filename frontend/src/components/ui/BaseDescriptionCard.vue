<template>
    <transition name="card-outer">
        <div v-show="isVisable"
            class="absolute w-full bg-black bg-opacity-30 h-screen top-0 left-0 flex justify-center "
            @click="$emit('close-description-card')">
            <transition name="card-inner">
                <div v-if="isVisable"
                    class="bg-white self-start mt-32 rounded-lg box-border border-solid border-2 border-black shadow">
                    <slot></slot>
                </div>
            </transition>

        </div>
    </transition>


</template>
<script>
import { inject } from 'vue';
export default {
    emits: ['close-description-card'],
    setup() {
        const isVisable = inject('descriptionIsShowed');
        return{
            isVisable,
        };
    }
}
</script>
<style scoped>
.card-outer-enter-active,
.card-outer-leave-active{
    transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.card-outer-enter-from,
.card-outer-leave-to{
    opacity: 0;
}

.card-inner-enter-active{
    transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
}
.card-inner-leave-active {
    transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.card-inner-enter-from{
    opacity: 0;
    transform: scale(0.8);
}
.card-outer-leave-to {
opacity: 0;
}
</style>
