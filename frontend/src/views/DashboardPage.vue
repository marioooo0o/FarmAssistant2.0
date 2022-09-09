<template>
    <Navbar />
    <ResponseModal />
</template>
<script>
import PractiseList from '../components/practises/PractiseList.vue'
import FieldList from '../components/fields/FieldList.vue'
import Spinner from '../components/ui/BaseSpinner.vue'
import ResponseModal from '../components/ui/ResponseModal.vue'
import Navbar from '../components/navbar/TheNavbar.vue'
import FieldDescription from '../components/fields/FieldDescription.vue'
export default {
    components: { ResponseModal, Navbar }
}
</script>
