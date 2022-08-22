<template>
    <transition name="card-outer">
        <div class="absolute w-full bg-black bg-opacity-30 h-screen top-0 left-0 flex justify-center">
            <transition name="card-inner">
                <div class="bg-white self-start mt-32 p-12 rounded-lg box-border border-solid border-2 border-black shadow"
                    ref="target">
                    <slot></slot>
                </div>
            </transition>

        </div>
    </transition>


</template>
<script>
import { ref } from 'vue'
import { onClickOutside } from '@vueuse/core'
export default {
    emits: ['close-description-card'],
    setup(props,{ emit }) {
        const target = ref(null)
        onClickOutside(target, function(){
            emit('close-description-card')});
        return { target }
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
