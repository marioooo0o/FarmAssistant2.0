<template>
    <base-description-card>
    <div class="flex flex-col items-center font-semibold tracking-wider px-16">
            <h1 class="text-2xl">Edytuj Produkt</h1>
            <div class="flex justify-between items-center">
                    <span>Nazwa środka:</span>
                    <span>{{product.name}}</span>
            </div>
        </div>
    </base-description-card>
</template>
<script>
export default {
    props: {
        product: {
            type: Object,
            required: true
        }
    }
    
}
</script>
