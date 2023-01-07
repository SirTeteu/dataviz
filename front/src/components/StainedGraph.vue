<template>
    <div class="align graph">
        <div 
            class="align y-axis-label" 
            :style="{ 
                'min-height': `${divLabelHeight}px`, 
                'max-height': `${divLabelMaxHeight}px`
            }">
            <span 
                v-for="(item, index) in Yaxis" 
                :key="item.value"
                :class="{ space: group && index < Yaxis.length - 1 && Yaxis[index].param != Yaxis[index+1].param}"
            >
                    {{ item.value }}
            </span>
        </div>

        <div class="align boxes" v-for="column in data.length" :key="Xaxis[column-1].key">
            <Box 
                v-for="(item, index) in data[column-1]" 
                :key="`${Xaxis[column-1].key}-${Yaxis[index].value}`"
                :value="item"
                :space="group && index < Yaxis.length - 1 && Yaxis[index].param != Yaxis[index+1].param"
                :tooltipMessage="`${item} refugiados de ${Xaxis[column-1].key} em ${Yaxis[index].detail}`"
                hoverEffect
            />

            <span class="x-axis-label">{{ Xaxis[column-1].key }}</span>
        </div>

        <div class="subtitle">
            <div class="align"><Box :value="0" /> <span>0</span></div>
            <div class="align"><Box :value="1" /> <span>1</span></div>
            <div class="align"><Box :value="5" /> <span>De 2 a 10</span></div>
            <div class="align"><Box :value="15" /> <span>De 11 a 100</span></div>
            <div class="align"><Box :value="114" /> <span>De 101 a 1000</span></div>
            <div class="align"><Box :value="1001" /> <span>A partir de 1001</span></div>
        </div>
    </div>
</template>

<script>
import Box from "./Box";

export default {
    name: 'StainedGraph',

    components: {
        Box
    },

    props: {
        Yaxis: {
            type: Array,
            required: true
        },

        Xaxis: {
            type: Array,
            required: true
        },
        
        group: {
            type: Boolean,
            required: false,
            default: false
        }
    },

    data() {
        return {
            lineHeight: 18
        }    
    },

    computed: {
        data() {
            let matrix = [];

            for(let column of this.Xaxis) {
                let columnArray = [];

                for (let line of this.Yaxis) {

                    for (let i = 0; i < column.items.length; i++) {
                        if (column.items[i].key == line.value) {
                            columnArray.push(column.items[i].count);
                            break;
                        }

                        if (i == column.items.length - 1) {
                            columnArray.push(0);

                        }
                    }

                }

                matrix.push(columnArray);
                
            }

            return matrix;
        },

        divLabelHeight() {
            return this.lineHeight * this.Yaxis.length;
        },

        divLabelMaxHeight() {
            let diffParam = [];
            this.Yaxis.map(element => {
                if(!diffParam.includes(element.param)) {
                    diffParam.push(element.param);
                }
            });

            return this.divLabelHeight + (4 * diffParam.length);
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.space {
    margin-bottom: 5px;
}

.align {
    display: flex;
}

.align.graph {
    justify-content: center;
}

.align.y-axis-label {
    font-size: 12px;
    flex-direction: column;
    justify-content: space-around;
    align-items: flex-end;
    padding-right: 5px;
}

.align.boxes {
    flex-direction: column;
}

.x-axis-label {
    font-size: 12px;
    margin-top: 5px;
    writing-mode: vertical-lr;
    -webkit-writing-mode: vertical-lr;
    transform: rotate(180deg);
}

.subtitle {
    font-size: 12px;
    margin-left: 10px;
}

.subtitle .align {
    margin-bottom: 5px;
}

.subtitle .align span {
    margin-left: 5px;
}
</style>
