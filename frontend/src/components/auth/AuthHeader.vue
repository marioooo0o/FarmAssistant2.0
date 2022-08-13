<script>
export default {
    props: {
        border: String
    },
};
</script>

<template>
    <header class="flex justify-center">
        <div class="flex flex-col items-center max-w-screen-sm">
            <h1>
                <img alt="Logo FarmAssistant" class="w-96" height="439" src="@/assets/logo.png" width="550" />
            </h1>
            <blockquote class="italic font-light text-3xl leading-15 tracking-most-widest text-center mt-16">
                “Całe życie byłem pojebany Jeszcze zrobić na tym sos pojebane!”
                <br />
                ~ Młody Jeżyk 47
            </blockquote>
        </div>
    </header>
</template>
