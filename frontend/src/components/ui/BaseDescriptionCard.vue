<template>
    <transition name="card-outer">
        <div class="absolute w-full bg-black bg-opacity-30 h-screen top-0 left-0 flex justify-center">
            <transition name="card-inner">
                <div class="bg-white self-start m-auto p-12 rounded-lg box-border border-solid border-2 border-fa-primary shadow relative"
                    ref="target">
                    <div v-if="mainIcons" class="absolute top-2 right-4">
                        <button type="submit" :form="formName">
                            <i class="fa-solid fa-check text-green-500 text-3xl mr-3 hover:text-green-400" @click="$emit('save-clicked')"></i>
                        </button>
                        <i class="fa-solid fa-xmark text-red-600 text-3xl hover:text-red-400" @click="$emit('cancel-clicked')"></i>
                    </div>
                    <slot>
                        
                    </slot>
                </div>
            </transition>

        </div>
    </transition>


</template>
<script>
import { ref } from 'vue'
import { onClickOutside } from '@vueuse/core'
export default {
    emits: ['close-description-card', 'save-clicked', 'cancel-clicked'],
    props: {
        mainIcons: {
            type: Boolean,
            default: false
        },
        formName: {
            type: String,
            required: false,
        },
    },
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
