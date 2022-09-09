<template>
    <transition name="card-outer">
        <div class="absolute w-full bg-black bg-opacity-30 h-screen top-0 left-0 flex justify-center">
            <transition name="card-inner">
                <div class="bg-white self-start m-auto p-12 rounded-lg box-border border-solid border-2 shadow relative flex
                flex-col items-center justify-center gap-2">
                    <div class="border-4 rounded-full w-24 h-24 flex justify-center items-center" :class="borderColor">
                        <i v-if="success" class="fa-solid fa-check text-fa-primary text-7xl"></i>
                        <i v-else class="fa-solid fa-xmark text-red-500 text-7xl"></i>
                    </div>
                    <h1 class="text-2xl">{{title}}</h1>
                    <p class="text-xl">{{message}}</p>
                </div>
            </transition>
        </div>
    </transition>
</template>
<script>
import { computed } from 'vue';
export default {
    props:{
        success: {
            type:Boolean,
            required: true,
        },
        message: {
            type:String,
            required: true,
        }
    },
    setup(props) {
        const title = computed(() => {
            return props.success ? "Sukces!" : "Error!"
        });
        const borderColor = computed(() => {
            return props.success ? "border-fa-primary" : "border-red-500";
        });

        return {
            title,
            borderColor
        }

    }
}
</script>
<style>
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