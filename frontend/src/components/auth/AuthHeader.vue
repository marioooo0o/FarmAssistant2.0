<template>
    <header class="border-black flex justify-center" :class="border">
        <div class="flex flex-col items-center max-w-screen-sm">
            <h1>
                <img alt="Logo FarmAssistant" class="w-96" height="439" src="@/assets/logo.png" width="550" />
            </h1>
            <blockquote class="italic font-light text-white font-bold text-l leading-15 tracking-most-widest text-center mt-16">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis sed, laboriosam rerum ipsa nulla molestias.
                <br />
                ~ link do schronisaka piesków
            </blockquote>
        </div>
    </header>
</template>
<script>
import { computed } from 'vue';
export default {
    props: {
        border: String
    },
    setup(props){
        const border = computed(()=>{
            if(props.border === 'left'){
                return 'border-l-2';
            }
            else if(props.border === 'right'){
                return 'border-r-2';
            }
        });

        return {
            border,
        }
    }
};
</script>


