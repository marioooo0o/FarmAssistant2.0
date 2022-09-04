<template>
    <button class="bg-white py-1 px-6 rounded-full border border-fa-primary" @click="$emit('edit-clicked')">
        <slot>
        </slot>
    </button>
</template>
<script>
export default {
    
}
</script>
