<template>
    <el-tooltip :content="quantity" placement="bottom" effect="dark">
      <div class="bg-white p-1 w-full rounded-full">
        <div class="h-4 rounded-full relative border-b-2" :class="barColor" :style="{width: barWidth }"></div>
      </div>
    </el-tooltip>
    
    

</template>
<script>
import { ref, computed } from 'vue';
export default {
    props: {
        quantity: {
            type: Number,
            required: true,
        }
    },
    setup(props) {
        const width = computed(() => {
            return props.quantity / 10;
        });
        
        const barColor = computed(() => {
            if(width.value < 0.5) return 'bg-red-400';
            else if (width.value >= 0.5 && width.value < 0.75) return 'bg-orange-400';
            else return 'bg-fa-primary'; 
        });

        const barWidth = computed(() => {
            if(width.value > 1) return '100%';
            else{
            } return `${width.value*100}%`;
        });

        const barClass = computed(() => {
            return `${barWidth.value} ${barColor.value}`;
        });
        
        const quantity = computed(() => {
          return `${props.quantity} l`;
        });
        return {
            barColor,
            barWidth,
            quantity
        }

    }
}
</script>
<style scoped>
    .tooltip {
  position: relative;
  display: inline-block;
}
    .tooltip .tooltiptext {
  visibility: hidden;
  width: max-content;
  background-color: gold;
  color: black;
  text-align: center;
  border-radius: 6px;
  padding: 5px 5px;
  
  /* Position the tooltip */
  position: absolute;
  z-index: 1;
  top: 100%;
  left: 50%;
  margin-left: -60px;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
/* .hovertext {
  position: relative;
  border-bottom: 1px dotted black;
}
.hovertext:before {
  content: attr(data-hover);
  visibility: hidden;
  opacity: 0;
  width: max-content;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 5px;
  padding: 5px 5px;
  transition: opacity 0.5s ease-in-out;

  position: absolute;
  z-index: 1;
  left: 0;
  top: 110%;
}
.hovertext:hover:before {
  opacity: 1;
  visibility: visible;
} */
</style>
