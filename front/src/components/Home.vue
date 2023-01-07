<template>
	<div class="container">
		<div class="align" v-if="((estados.length > 0) && refugiados.length > 0)">
			<v-slider
				class="slider-input"
				label="Ano"
				v-model="input.year"
				@change="selectData"
				:max="sliderRange.max"
				:min="sliderRange.min"
				thumb-color="#045a8d"
				thumb-label="always"
				vertical
			></v-slider>	

			<StainedGraph 
				:Yaxis="estados"
				:Xaxis="dataSelected"
				group
			/>
		</div>

		<div class="center-loading" v-else>
			<v-progress-circular
				:size="50"
				color="#045a8d"
				indeterminate
			></v-progress-circular>
		</div>
	</div>
</template>

<script>
import StainedGraph from './StainedGraph';

import providerRefugiado from "../providers/RefugiadoProvider";
import providerEstado from "../providers/EstadoProvider";

export default {
  name: 'Home',

  components: {
	StainedGraph
  },

  data() {
	return {
		input: {
			year: 0
		},

		sliderRange: {
			max: 0,
			min: 0
		},

		dataSelected: [],

		estados: [],
		refugiados: []
	}
  },

  mounted() {
		this.getEstados();
		this.getRefugiados();
	},

	methods: {
		getEstados() {
			providerEstado.get({
				success: data => {
					this.estados = data.data
				},

				error: (error) => {
					console.log(error);
				}
			});
		},

		getRefugiados() {
			providerRefugiado.get({
				success: data => {
					this.refugiados = data.data;

					this.sliderRange.max = this.refugiados[0].key * 1;
					this.sliderRange.min = this.refugiados[this.refugiados.length-1].key * 1;
					this.input.year = this.sliderRange.max;

					this.selectData();
				},

				error: (error) => {
					console.log(error);
				}
			});
		},

		selectData() {
			for(let data of this.refugiados) {
				if(data.key == this.input.year) {
					this.dataSelected = data.items;
				}
			}
		}
	}
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.container {
	max-width: 1180px;
    margin: 0 auto;
}

.align {
	display: flex;
}

.center-align {
	margin: 0 auto;
}

.center-loading {
	display: flex;
    justify-content: center;
    margin-top: 225px;
}

.slider-input {
	margin: 0 50px 0 0;
	max-width: 50px;
}
</style>
