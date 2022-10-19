<template>
    <Navbar />
    <div>
        Profil strona
        <div class="w-1/6">
            <el-input v-model="input" placeholder="Please input">
                <template #suffix>
                    <el-icon class="el-input__icon">
                        ha
                    </el-icon>
                </template>
            </el-input>
        </div>
        
    </div>
</template>
<script>
import Navbar from '../components/navbar/TheNavbar.vue'
import { ref } from 'vue'
export default {
    components: { Navbar },
    
    setup(props) {
        const input = ref('');

        return {
            input
        }
    }
}
</script>
