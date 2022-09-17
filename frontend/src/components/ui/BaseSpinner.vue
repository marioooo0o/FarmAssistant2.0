<template>
    <transition name="card-outer">
        <div class="absolute w-full bg-black bg-opacity-30 h-screen top-0 left-0 flex justify-center z-20">
            <transition name="card-inner">
                <div class="bg-white self-start m-auto p-12 rounded-full box-border border-solid border-2 shadow relative flex
                flex-col items-center justify-center gap-2">
                    <div style="border-top-color:transparent" class="w-16 h-16 border-4 border-fa-primary rounded-full animate-spin"></div>
                    <span>Ładowanie...</span>
                </div>
            </transition>
        </div>
    </transition>
</template>