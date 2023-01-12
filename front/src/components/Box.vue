<template>
	<v-tooltip bottom open-delay="300" :disabled="!tooltipMessage || value == 0">
		<template v-slot:activator="{ on }">
			<v-hover v-slot:default="{ hover }">
				<div 
					:class="{ box: true, space: space }" 
					:style="{
						'background-color': hoverEffect && hover ? colorHovered : color,
						transition: 'background .3s cubic-bezier(.25,.8,.5,1)'
					}"
					v-on="on" 
				/>
			</v-hover>

		</template>
		<span>{{ tooltipMessage }}</span>
	</v-tooltip>
</template>

<script>
import color from '../helpers/color';

export default {
	name: 'Box',

	props: {
		value: {
			type: Number,
			required: true
		},

		tooltipMessage: {
			type: String,
			required: false,
			default: ''
		},

		hoverEffect: {
			type: Boolean, 
			required: false,
			default: false
		},

		space: {
			type: Boolean,
			required: false,
			default: false
		}
	},

	computed: {
		color() {
			if (this.value == 1) {
				return '#d0d1e6';
			
			} else if (this.value > 1 && this.value <= 10) {
				return '#a6bddb';
			
			} else if (this.value > 10 && this.value <= 100) {
				return '#74a9cf';
			
			} else if (this.value > 100 && this.value <= 1000) {
				return '#2b8cbe';
			
			} else if (this.value > 1000) {
				return '#045a8d';
			
			}

			return '#f1eef6';
		},

		colorHovered() {
			return color.lightenDarkenColor(-0.5, this.color);
		}
	}
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.box {
	width: 18px;
	height: 18px;
}

.space {
    margin-bottom: 5px;
}
</style>
