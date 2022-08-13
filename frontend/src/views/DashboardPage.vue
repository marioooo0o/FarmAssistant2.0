<template>
    <div>
        <Navbar/>
        <PractiseList />
    </div>
</template>
<script>
import PractiseList from '../components/practises/PractiseList.vue'
import FieldList from '../components/fields/FieldList.vue'
import Navbar from '../components/navbar/Navbar.vue'
export default {
    components: { PractiseList, FieldList, Navbar }
}
</script>
