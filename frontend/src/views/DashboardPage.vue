<template>
    <Navbar />
    <FieldDescription />
</template>
<script>
import PractiseList from '../components/practises/PractiseList.vue'
import FieldList from '../components/fields/FieldList.vue'
import Navbar from '../components/navbar/TheNavbar.vue'
import FieldDescription from '../components/fields/FieldDescription.vue'
export default {
    components: { FieldDescription, Navbar }
}
</script>
