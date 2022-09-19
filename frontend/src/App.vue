<template>
  <spinner v-if="isLoading"/>
  <ResponseModal v-if="responseObj.hasResponse" :success=responseObj.status :message=responseObj.message />
    
  <RouterView />
</template>


<script>
import { computed} from 'vue'
import { useStore } from 'vuex';
import { RouterView } from 'vue-router';
import ResponseModal from './components/ui/ResponseModal.vue';
export default{
  components: { RouterView,  ResponseModal  },
  setup(props) {
    const store = useStore();

    const isLoading = computed(() => {
      return store.getters.isLoading;
    });

    const responseObj = computed(() => {
      return store.getters['response/getResponse'];
    });

    return {
      isLoading,
      responseObj
    }
}
}

</script>


